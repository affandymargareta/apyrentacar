<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment; 
use App\Models\Seller;
use App\Models\TanpaSopir; 
use App\Models\DenganSopir; 
use App\Models\CityPrice;
use App\Models\City;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
	/**
	 * Receive notification from payment gateway
	 *
	 * @param Request $request payment data
	 *
	 * @return json
	 */
	public function notification(Request $request)
	{
		$payload = $request->getContent();
		$notification = json_decode($payload);

		$validSignatureKey = hash("sha512", $notification->order_id . $notification->status_code . $notification->gross_amount . config('services.midtrans.serverKey'));

		if ($notification->signature_key != $validSignatureKey) {
			return response(['message' => 'Invalid signature'], 403);
		}

		$this->initPaymentGateway();
		$statusCode = null;

		$paymentNotification = new \Midtrans\Notification();
		// TODO set payment status in merchant's database to 'Denied'
        $order = Order::where('invoice', $paymentNotification->order_id)->firstOrFail();


		if ($order->isPaid()) {
			return response(['message' => 'The order has been paid before'], 422);
		}

		$transaction = $paymentNotification->transaction_status;
		$type = $paymentNotification->payment_type;
		$orderId = $paymentNotification->order_id;
		$fraud = $paymentNotification->fraud_status;

		$vaNumber = null;
		$vendorName = null;
		if (!empty($paymentNotification->va_numbers[0])) {
			$vaNumber = $paymentNotification->va_numbers[0]->va_number;
			$vendorName = $paymentNotification->va_numbers[0]->bank;
		}

		$paymentStatus = null;
		if ($transaction == 'capture') {
			// For credit card transaction, we need to check whether transaction is challenge by FDS or not
			if ($type == 'credit_card') {
				if ($fraud == 'challenge') {
					// TODO set payment status in merchant's database to 'Challenge by FDS'
					// TODO merchant should decide whether this transaction is authorized or not in MAP
					$paymentStatus = Payment::CHALLENGE;
				} else {
					// TODO set payment status in merchant's database to 'Success'
					$paymentStatus = Payment::SUCCESS;
				}
			}
		} else if ($transaction == 'settlement') {
			// TODO set payment status in merchant's database to 'Settlement'
			$paymentStatus = Payment::SETTLEMENT;
		} else if ($transaction == 'pending') {
			// TODO set payment status in merchant's database to 'Pending'
			$paymentStatus = Payment::PENDING;
		} else if ($transaction == 'deny') {
			// TODO set payment status in merchant's database to 'Denied'
			$paymentStatus = PAYMENT::DENY;
		} else if ($transaction == 'expire') {
			// TODO set payment status in merchant's database to 'expire'
			$paymentStatus = PAYMENT::EXPIRE;
		} else if ($transaction == 'cancel') {
			// TODO set payment status in merchant's database to 'Denied'
			$paymentStatus = PAYMENT::CANCEL;
		}
 
		$paymentParams = [
			'order_id' => $order->id,
            'fitur' => $order->fitur,
			'number' => Payment::generateCode(),
			'amount' => $paymentNotification->gross_amount,
			'method' => 'midtrans',
			'status' => $paymentStatus,
			'token' => $paymentNotification->transaction_id,
			'payloads' => $payload,
			'payment_type' => $paymentNotification->payment_type,
			'va_number' => $vaNumber,
			'vendor_name' => $vendorName,
			'pdf_url' => isset($notification->pdf_url) ? $notification->pdf_url : null,
			'biller_code' => $paymentNotification->biller_code,
			'bill_key' => $paymentNotification->bill_key,
		];
		$payment = Payment::create($paymentParams);

		if ($paymentStatus && $payment) {
			\DB::transaction(
				function () use ($order, $payment) {
					if (in_array($payment->status, [Payment::SUCCESS, Payment::SETTLEMENT])) {
						$order->payment_status = Order::PAID;
						$order->save();
					}
				}
			);
		}

		$message = 'Payment status is : '. $paymentStatus;

		$response = [
			'code' => 200,
			'message' => $message,
		];

		return response($response, 200);
	}

    /**
     * Show completed payment status
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function completed(Request $request)
    {
        $code = $request->query('order_id');

        try {
            $order = Order::where('invoice', $code)->firstOrFail();

            if ($order) {
                // Pastikan order ditemukan dan valid
                $this->sendOrderEmail($order);
            }

            return redirect()->route('home')->with('success', 'Transaksi berhasil!');
        } catch (\Exception $e) {
            Log::error('Order completion error: ' . $e->getMessage());

            return redirect()->route('home')->with('error', 'An error occurred while processing your transaction.');
        }
    }



    /**
     * Show unfinish payment page
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unfinish(Request $request)
    {
        $code = $request->query('order_id');
        $order = Order::where('invoice', $code)->firstOrFail();
        Log::warning('Unfinished payment for order ID: ' . $order->id);

        return redirect(route('user.dashboard'))->with('error', "Sorry, we couldn't process your payment.");
    }

    /**
     * Show failed payment page
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function failed(Request $request)
    {
        $code = $request->query('order_id');
        $order = Order::where('invoice', $code)->firstOrFail();
        Log::warning('Failed payment for order ID: ' . $order->id);

        return redirect(route('user.dashboard'))->with('error', "Sorry, we couldn't process your payment.");
    }

    /**
     * Send order email with invoice PDF
     *
     * @param Order $order
     * @return void
     */
    private function sendOrderEmail(Order $order)
    {
        try {
            // Ambil data order dan relasi
            $orderID = Order::where('id', $order->id)->orderBy('created_at', 'DESC')->firstOrFail();
            $seller = Seller::where('id', $orderID->seller_id)->first();

            if ($orderID->fitur == 'v1') {

                    $seller = Seller::where('id', $orderID->seller_id)->first();
                    $product = TanpaSopir::where('id', $orderID->product_id)->first();
                
                    $data["seller_name"]= $seller->name;
                    $data["seller_telpon"]= $seller->phone;
                    $data["seller_email"]= $seller->email;
                    $data["invoice"]= $orderID->invoice;
                    $data["payment_status"]= $orderID->payment_status;
                    $data["wilayah"]= $orderID->wilayah;
                    $data["mulai"]= $orderID->mulai;
                    $data["akhir"]= $orderID->akhir;
                    $data["durasi"]= $orderID->durasi;
                    $data["jam_mulai"]= $orderID->jam_mulai;
                    $data["jam_akhir"]= $orderID->jam_akhir;
                    $data["plat_nomer"]= $orderID->plat_nomer;
                    $data["product_name"]= $product->productName->name;
                    $data["product"]= $product->wilayah;
                    $data["product_price"]= $product->price;
                    $data["customer_name"]= $orderID->customer_name;
                    $data["customer_telpon"]= $orderID->customer_telpon;
                    $data["customer_email"]= $orderID->customer_email;
                    $data["price"]= $orderID->price;
                    $data["opration1"]= "carengibran@gmail.com";
                    $data["opration2"]= "carengibran@gmail.com";
            
                    $pdf = Pdf::loadView('FrontEnd.seller-invoice-v1', $data)
                        ->setPaper('a4', 'portrait')
                        ->setWarnings(false)
                        ->setOptions(['dpi' => 250, 'isHtml5ParserEnabled' => true, 'defaultFont' => 'sans-serif']);
            
                    Mail::send('FrontEnd.seller-email-v1', $data, function ($message) use ($data, $pdf) {
                        $message->to($data['seller_email'])
                            ->subject($data['product_name'])
                            ->attachData($pdf->output(), 'voucher.pdf', ['mime' => 'application/pdf'])
                            ->cc([$data['opration1'], $data['opration2']]);
                    });
                
            } elseif ($orderID->fitur == 'v2') {

                    $seller = Seller::where('id', $orderID->seller_id)->first();
                    $product = DenganSopir::where('id', $orderID->product_id)->first();
                    $jemputCity = City::orderBy('created_at', 'DESC')->where('id', $orderID->lokasi_jemput)->first();
                    $kembaliCity = City::orderBy('created_at', 'DESC')->where('id', $orderID->lokasi_kembali)->first();
            
                    if(!empty($orderID->lokasi_jemput)){
                        $jemputCitys = $jemputCity->city_name;
                        $lokasi_jemput_lengkap = $orderID->lokasi_jemput_lengkap;
                    }else {
                        $jemputCitys = '';
                        $lokasi_jemput_lengkap  = '';
                    }
                    if(!empty($orderID->lokasi_kembali)){
                        $kembaliCitys = $kembaliCity->city_name;
                        $lokasi_kembali_lengkap = $orderID->lokasi_kembali_lengkap;
            
                    }else {
                        $kembaliCitys = '';
                        $lokasi_kembali_lengkap = '';
                    }
            
                    $kembalibanding = City::orderBy('created_at', 'DESC')->where('city_name', $orderID->wilayah)->first();
            
                    if($kembalibanding->province_id != $orderID->jemput_id) {
                        $jemput = CityPrice::where('province_id', $orderID->jemput_id)->where('product_id', $product->name)->first();
                        $jemputPrice = $jemput->price ?? '';
                        $jemputzona = $jemput->zona ?? '';
                    } else {
                        $jemputPrice = 0;
                        $jemputzona = '';
                    }
            
                    if(!empty($orderID->kembali_id)){
            
                        if($kembalibanding->province_id != $orderID->kembali_id) {
                            $Kembali = CityPrice::where('province_id', $orderID->kembali_id)->where('product_id', $product->name)->first();
                            $kembaliPrice = $Kembali->price ?? '';
                            $Kembalizona = $Kembali->zona ?? '';
                        } else {
                            $kembaliPrice = 0;
                            $Kembalizona = '';
                        }
            
                    }else {
                        $kembaliPrice = 0;
                        $Kembalizona = '';
                    }
            
                    
                    if(!empty($orderID->addon_price)){
                        $addon_price = $orderID->addon_price;
                    }else {
                        $addon_price = 0;
                    }
                    if(!empty($orderID->addon_hari)){
                        $addon_hari = $orderID->addon_hari;
                    }else {
                        $addon_hari = 0;
                    }
            
                    // dd($orderID, $kembalibanding, $kembaliPrice, $Kembalizona);
            
                    // dd($kembaliPrice, $jemputPrice);
                    $totalHari = $orderID->durasi -1;
                    $durasi = date_create($orderID->mulai)->modify("+ {$totalHari} days")->format("D, d F Y");
            
                    $data["seller_name"]= $seller->name;
                    $data["seller_telpon"]= $seller->phone;
                    $data["seller_email"]= $seller->email;
                    $data["invoice"]= $orderID->invoice;
                    $data["payment_status"]= $orderID->payment_status;
                    $data["wilayah"]= $orderID->wilayah;
                    $data["jemput_id"]= $orderID->jemput_id;
                    $data["lokasi_jemput"]= $jemputCitys;
                    $data["lokasi_jemput_lengkap"]= $lokasi_jemput_lengkap;
                    $data["jemputPrice"]= $jemputPrice;
                    $data["jemputzona"]= $jemputzona;
                    $data["kembali_id"]= $orderID->kembali_id;
                    $data["lokasi_kembali"]= $kembaliCitys;
                    $data["lokasi_kembali_lengkap"]= $lokasi_kembali_lengkap;
                    $data["kembaliPrice"]= $kembaliPrice;
                    $data["Kembalizona"]= $Kembalizona;
                    $data["mulai"]= $orderID->mulai;
                    $data["durasi"]= $durasi;
                    $data["hari"]= $orderID->durasi;
                    $data["jam_mulai"]= $orderID->jam_mulai;
                    $data["jam_akhir"]= $orderID->jam_akhir;
                    $data["product_name"]= $product->productName->name;
                    $data["product"]= $product->wilayah;
                    $data["product_price"]= $product->price;
                    $data["customer_name"]= $orderID->customer_name;
                    $data["customer_telpon"]= $orderID->customer_telpon;
                    $data["customer_email"]= $orderID->customer_email;
                    $data["addon_price"]= $addon_price;
                    $data["addon_hari"]= $addon_hari;
                    $data["price"]= $orderID->price;
                    $data["order_id"]= $orderID->id;
                    $data["opration1"]= "carengibran@gmail.com";
                    $data["opration2"]= "carengibran@gmail.com";
            
                    $pdf = Pdf::loadView('FrontEnd.seller-invoice-v2', $data)
                        ->setPaper('a4', 'portrait')
                        ->setWarnings(false)
                        ->setOptions(['dpi' => 250, 'isHtml5ParserEnabled' => true, 'defaultFont' => 'sans-serif']);
            
                    Mail::send('FrontEnd.seller-email-v2', $data, function ($message) use ($data, $pdf) {
                        $message->to($data['seller_email'])
                            ->subject($data['product_name'])
                            ->attachData($pdf->output(), 'voucher.pdf', ['mime' => 'application/pdf'])
                            ->cc([$data['opration1'], $data['opration2']]);
                    });
                
            }


        } catch (\Exception $e) {
            // Log any errors for debugging
            Log::error('Order email sending error: ' . $e->getMessage());
        }
    }

    // ... (rest of the methods)


    /**
     * Initialize the payment gateway configuration
     *
     * @return void
     */
    protected function initPaymentGateway()
	{
		// Set your Merchant Server Key
		\Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
		// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
		\Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
		// Set sanitization on (default)
		\Midtrans\Config::$isSanitized = config('services.midtrans.isSanitized');
		// Set 3DS transaction for credit card to true
		\Midtrans\Config::$is3ds = config('services.midtrans.is3ds');
	}
}
