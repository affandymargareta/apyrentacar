<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment; 
use App\Models\Seller;
use App\Models\DenganSopir;
use App\Models\TanpaSopir; 
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function notification(Request $request)
    {
        $payload = $request->getContent();
        $notification = json_decode($payload);

        $validSignatureKey = hash("sha512", $notification->order_id . $notification->status_code . $notification->gross_amount . config('services.midtrans.serverKey'));

        if ($notification->signature_key != $validSignatureKey) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $this->initPaymentGateway();
        $paymentNotification = new \Midtrans\Notification();
        $order = Order::where('invoice', $paymentNotification->order_id)->firstOrFail();

        if ($order->isPaid()) {
            return response()->json(['message' => 'The order has been paid before'], 422);
        }

        $transaction = $paymentNotification->transaction_status;
        $type = $paymentNotification->payment_type;
        $fraud = $paymentNotification->fraud_status;

        $paymentStatus = $this->determinePaymentStatus($transaction, $type, $fraud);

        $paymentParams = [
            'order_id' => $order->invoice,
            'number' => Payment::generateCode(),
            'fitur' =>  $order->fitur,
            'amount' => $paymentNotification->gross_amount,
            'method' => 'midtrans',
            'status' => $paymentStatus,
            'token' => $paymentNotification->transaction_id,
            'payloads' => $payload,
            'payment_type' => $paymentNotification->payment_type,
            'va_number' => $paymentNotification->va_numbers[0]->va_number ?? null,
            'vendor_name' => $paymentNotification->va_numbers[0]->bank ?? null,
            'pdf_url' => $notification->pdf_url ?? null,
            'biller_code' => $paymentNotification->biller_code,
            'bill_key' => $paymentNotification->bill_key,
        ];
        $payment = Payment::create($paymentParams);
        $this->sendOrderEmail($payment);

        if ($paymentStatus && $payment) {
            \DB::transaction(function () use ($order, $payment) {
                
                if (in_array($payment->status, [Payment::SUCCESS, Payment::SETTLEMENT])) {
                    $order->payment_status = Order::PAID;
                    $order->save();
                }
            });
        }

        return response()->json(['code' => 200, 'message' => 'Payment status is : '. $paymentStatus], 200);
    }

    /**
     * Determine the payment status based on transaction type and fraud status
     *
     * @param string $transaction
     * @param string $type
     * @param string $fraud
     * @return string
     */
    private function determinePaymentStatus($transaction, $type, $fraud)
    {
        switch ($transaction) {
            case 'capture':
                return ($type === 'credit_card' && $fraud === 'challenge') ? Payment::CHALLENGE : Payment::SUCCESS;
            case 'settlement':
                return Payment::SETTLEMENT;
            case 'pending':
                return Payment::PENDING;
            case 'deny':
                return Payment::DENY;
            case 'expire':
                return Payment::EXPIRE;
            case 'cancel':
                return Payment::CANCEL;
            default:
                return Payment::PENDING;
        }
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
    private function sendOrderEmail($payment)
    {
        $orderID = Order::where('invoice', $payment->order_id)->orderBy('created_at', 'DESC')->firstOrFail();
         $v = "v1";
        if($orderID->fitur != $v){
            // v2 dengan sopir
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
                $data["akhir"]= $orderID->akhir;
                $data["durasi"]= $orderID->durasi;
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
                $data["opration1"]= "asyarifudin591@gmail.com";
                $data["opration2"]= "affandy62105@gmail.com";
        
                $pdf = PDF::loadView('FrontEnd.seller-invoice-v2', $data)
                ->setPaper('a4', 'portrait')->setWarnings(false)
                ->setOptions(['dpi' => 250, 'isHtml5ParserEnabled' => true, 'defaultFont' => 'sans-serif']);
        
                // return $pdf->stream(rand(1,50). '.' . 'pdf');
        
        
                // Send email with PDF attachment
                Mail::send('FrontEnd.seller-email-v2', $data, function($message) use ($data, $pdf) {
                    $message->to($data['seller_email'])
                        ->subject($data['product_name'])
                        ->attachData(
                            $pdf->output(),
                            'voucher.pdf',
                            [
                                'mime' => 'application/pdf',
                            ]
                        )
                        ->cc([
                            $data['opration1'],
                            $data['opration2']
                        ]); // Dynamically add CC recipients
                });
                // v2 dengan sopir
            }else {
            // v2 tanpa sopir
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
            $data["opration1"]= "asyarifudin591@gmail.com";
            $data["opration2"]= "affandy62105@gmail.com";

            $pdf = PDF::loadView('FrontEnd.seller-invoice-v1', $data)
            ->setPaper('a4', 'portrait')->setWarnings(false)
            ->setOptions(['dpi' => 250, 'isHtml5ParserEnabled' => true, 'defaultFont' => 'sans-serif']);

            // return $pdf->stream(rand(1,50). '.' . 'pdf');

            // Send email with PDF attachment
            Mail::send('FrontEnd.seller-email-v1', $data, function($message) use ($data, $pdf) {
                $message->to($data['seller_email'])
                    ->subject($data['product_name'])
                    ->attachData(
                        $pdf->output(),
                        'voucher.pdf',
                        [
                            'mime' => 'application/pdf',
                        ]
                    )
                    ->cc([
                        $data['opration1'],
                        $data['opration2']
                    ]); // Dynamically add CC recipients
            });
                // v2 tanpa sopir
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
