<?php

namespace App\Http\Controllers\FrontEnd;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Payment;
use Carbon\Carbon;
use App\Models\Seller;
use App\Models\Product;
use App\Models\User;
use App\Models\CityPrice;
use App\Models\City;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;


/**
 * PaymentController
 *
 * PHP version 8
 *
 * @category PaymentController
 * @package  PaymentController
 * @author   Sugiarto <AffandyMargareta@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
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
	 * @param Request $request payment data
	 *
	 * @return void
	 */
	public function completed(Request $request)
	{
		
		$code = $request->query('order_id');
		
		$order = Order::where('invoice', $code)->firstOrFail();

		try {
			$this->_OrderEmail($order);
			return redirect(route('user.dashboard'))->with(['success' => 'Transaksi berhasil!']);
		} catch (\Exception $e) {
            //JIKA TERJADI ERROR, MAKA ROLLBACK DATANYA
            dd($e);
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }

	}

	/**
	 * Show unfinish payment page
	 *
	 * @param Request $request payment data
	 *
	 * @return void
	 */
	public function unfinish(Request $request)
	{
		$code = $request->query('order_id');

		$order = Order::where('invoice', $code)->firstOrFail();

		\Session::flash('error', "Sorry, we couldn't process your payment.");

		return redirect(route('user.dashboard'))->with(['error' => "Sorry, we couldn't process your payment."]);

	}

	/**
	 * Show failed payment page
	 *
	 * @param Request $request payment data
	 *
	 * @return void
	 */
	public function failed(Request $request)
	{
		$code = $request->query('order_id');

		$order = Order::where('invoice', $code)->firstOrFail();

		\Session::flash('error', "Sorry, we couldn't process your payment.");

		return redirect(route('user.dashboard'))->with(['error' => "Sorry, we couldn't process your payment."]);

	}

	/**
	 * Save order items
	 *
	 * @param Order $order order object
	 *
	 * @return void
	 */

     private function _OrderEmail($order)
     {

        $orderID = Order::where('id', $order->id)->orderBy('created_at', 'DESC')->firstOrFail();
        $user = User::where('id', $orderID->user_id)->first();
        $seller = Seller::where('id', $orderID->seller_id)->first();
        $product = Product::where('id', $orderID->product_id)->first();
        $jemputCity = City::orderBy('created_at', 'DESC')->where('id', $orderID->lokasi_jemput)->first();
        $kembaliCity = City::orderBy('created_at', 'DESC')->where('id', $orderID->lokasi_kembali)->first();

        if(!empty($orderID->lokasi_jemput)){
            $jemputCitys = $jemputCity->city_name;
        }else {
            $jemputCitys = '';
        }
        if(!empty($orderID->lokasi_kembali)){
            $kembaliCitys = $kembaliCity->city_name;
        }else {
            $kembaliCitys = '';
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

        $data["user_id"]= $user->name;
        $data["seller_name"]= $seller->name;
        $data["seller_telpon"]= $seller->phone;
		$data["seller_email"]= $seller->email;
        $data["invoice"]= $orderID->invoice;
        $data["payment_status"]= $orderID->payment_status;
        $data["wilayah"]= $orderID->wilayah;
        $data["jemput_id"]= $orderID->jemput_id;
        $data["lokasi_jemput"]= $jemputCitys;
        $data["jemputPrice"]= $jemputPrice;
        $data["jemputzona"]= $jemputzona;
        $data["kembali_id"]= $orderID->kembali_id;
        $data["lokasi_kembali"]= $kembaliCitys;
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


        $pdf = PDF::loadView('FrontEnd.seller-invoice', $data)
        ->setPaper('a4', 'portrait')->setWarnings(false)
        ->setOptions(['dpi' => 250, 'isHtml5ParserEnabled' => true, 'defaultFont' => 'sans-serif']);
        
        // return $pdf->stream(rand(1,50). '.' . 'pdf');

        Mail::send('FrontEnd.seller-email', $data, function($message)use($data, $pdf) {

            $message->to($data["seller_email"], $data["seller_email"])

                    ->subject($data["product_name"])

                    ->attachData($pdf->output(),'voucher'. '.' . 'pdf');

        });

     }
}
