<?php

namespace App\Http\Controllers\FrontEnd;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Cart;

class OrderController extends Controller
{

    public function index($invoice)
    {        

        $order = Order::where('invoice', $invoice)->firstOrFail();
        return view('FrontEnd.invoice', compact('order'));
    }

	/**
	 * Generate payment token
	 *
	 * @param Order $order order data
	 *
	 * @return void
	 */
	private function _generatePaymentToken($order)
	{
		$this->initPaymentGateway();
		$customerDetails = [
			'first_name' => $order->customer_name,
			'email' => $order->customer_email,
			'phone' => $order->customer_telpon,
		];

		$params = [
			'enable_payments' => Payment::PAYMENT_CHANNELS,
			'transaction_details' => [
				'order_id' => $order->invoice,
				'gross_amount' => $order->price,
			],
			'customer_details' => $customerDetails,
			'expiry' => [
				'start_time' => date('Y-m-d H:i:s T'),
				'unit' => Payment::EXPIRY_UNIT,
				'duration' => Payment::EXPIRY_DURATION,
			],
		];

		$snap = \Midtrans\Snap::createTransaction($params);
		
		if ($snap->token) {
			$order->payment_token = $snap->token;
			$order->payment_url = $snap->redirect_url;
			$order->save();
		}
        // dd($params);

	}

    public function store(Request $request)
    {
        //VALIDASI DATANYA
        $validator = Validator::make($request->all(), [
            'cart_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        //DATABASE TRANSACTION BERFUNGSI UNTUK MEMASTIKAN SEMUA PROSES SUKSES UNTUK KEMUDIAN DI COMMIT AGAR DATA BENAR BENAR DISIMPAN, JIKA TERJADI ERROR MAKA KITA ROLLBACK AGAR DATANYA SELARAS
        DB::beginTransaction();
        try {
            //CHECK DATA CUSTOMER BERDASARKAN EMAIL

            //SIMPAN DATA ORDER
            $orderDate = date('Y-m-d H:i:s');
            $paymentDue = (new \DateTime($orderDate))->modify('+7 day')->format('Y-m-d H:i:s');

            $cart = Cart::where('id', $request->cart_id)->firstOrFail();
            // dd($cart);

            if(empty($cart->customer_name)){
				return redirect()->back()->withErrors(['msg' => 'payments/failed?']);
            }

            if(!empty($cart->kembali_id && $cart->lokasi_kembali)){
                    $kembali_id = $cart->kembali_id;
                    $lokasi_kembali = $cart->lokasi_kembali;    
            } else {
                $kembali_id = $cart->kembali_id ?? '';
                $lokasi_kembali = $cart->lokasi_kembali ?? '';
            } 

            $dt = Carbon::now();
            // dd($cart);
            $order = Order::create([
                'user_id' => Auth::id(),
                'seller_id' => $cart->seller_id,
                'invoice' => rand(100000, 999999). '-' .$dt->year, //INVOICENYA KITA BUAT DARI STRING RANDOM DAN WAKTU
                'order_date' => $orderDate,
                'payment_due' => $paymentDue,
                'payment_status' => Order::UNPAID,
                'wilayah' => $cart->wilayah,
                'addon_price' => $cart->addon_price,
                'addon_hari' => $cart->addon_hari,
                'biaya_aplikasi' => $cart->biaya_aplikasi,
                'jemput_id' => $cart->jemput_id,
                'lokasi_jemput' => $cart->lokasi_jemput,
                'kembali_id' => $kembali_id,
                'lokasi_kembali' => $lokasi_kembali,
                'mulai' => $cart->mulai,
                'durasi' => $cart->durasi,
                'jam_mulai' => $cart->jam_mulai,
                'jam_akhir' => $cart->jam_akhir,
                'product_id' => $cart->product_id,
                'customer_name' => $cart->customer_name,
                'customer_telpon' => $cart->customer_telpon,
                'customer_email' => $cart->customer_email,
                'price' => $cart->price,
            ]);

            // dd($order);

            $this->_generatePaymentToken($order);
            // $this->_OrderEmail($order);
            // dd($order);

            // create coupon transaksi

            // delete cart
            if($order){
                Cart::where('id', $cart->id)->delete();
            }

            // $this->_saveShiping($order);

            DB::commit();
            //REDIRECT KE HALAMAN FINISH TRANSAKSI
            // $this->_sendEmailOrderReceived($order);


            //REDIRECT KE HALAMAN FINISH TRANSAKSI
            Session::flash('success', 'Thank you. Your order has been received!');
            
            return redirect(url($order->payment_url));

            // return redirect(url($order->payment_url));
        } catch (\Exception $e) {
            //JIKA TERJADI ERROR, MAKA ROLLBACK DATANYA
            DB::rollback();
            dd($e);

            // DAN KEMBALI KE FORM TRANSAKSI SERTA MENAMPILKAN ERROR
            // return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

}
