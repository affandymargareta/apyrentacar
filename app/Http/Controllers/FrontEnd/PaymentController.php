<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment; 
use App\Models\Seller;
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
            \DB::transaction(function () use ($order, $payment) {
                
                if (in_array($payment->status, [Payment::SUCCESS, Payment::SETTLEMENT])) {
                    $order->payment_status = Order::PAID;
                    $order->save();
                }

                $this->_OrderEmail($order);
            });
        }

        return response()->json(['code' => 200, 'message' => 'Payment status is : '. $paymentStatus], 200);
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

        $order = Order::where('invoice', $code)->firstOrFail();
        $this->_OrderEmail($order);
        
        return redirect()->route('home')->with('error', 'An error occurred while processing your transaction.');
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
	private function _OrderEmail($order)
    {
        // Ambil data order dan relasi
        $orderID = Order::where('id', $order->id)->orderBy('created_at', 'DESC')->firstOrFail();
        $seller = Seller::where('id', $orderID->seller_id)->first();
        // Data untuk view dan PDF
        $data["seller_name"]= $seller->name;
        $data["seller_telpon"]= $seller->phone;
        $data["seller_email"]= $seller->email;
        $data["invoice"]= $orderID->invoice;
        $data["payment_status"]= $orderID->payment_status;
        $data["customer_name"]= $orderID->customer_name;
        $data["customer_telpon"]= $orderID->customer_telpon;
        $data["customer_email"]= $orderID->customer_email;
        $data["fitur"]= $orderID->fitur;
        $data["opration1"]= "carengibran@gmail.com";
        $data["opration2"]= "carengibran@gmail.com";
        $data["v1"]= "v1";

        Mail::send('FrontEnd.seller-email-v', $data, function ($message) use ($data, $pdf) {
            $message->to($data['seller_email'])
                ->subject($data['product_name'])
                ->attachData($pdf->output(), 'voucher.pdf', ['mime' => 'application/pdf'])
                ->cc([$data['opration1'], $data['opration2']]);
        });
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
