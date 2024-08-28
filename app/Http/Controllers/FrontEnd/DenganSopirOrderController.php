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
use App\Models\DenganSopirCart;
use App\Models\DenganSopir; 
use App\Models\CityPrice;
use App\Models\City;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class DenganSopirOrderController extends Controller
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
            /**
	 * Generate payment token
	 *
	 * @param Order $order order data
	 *
	 * @return void
	 */
	private function _OrderEmail($order)
	{
        // Ambil data order dan relasi
        $orderID = Order::where('id', $order->id)->orderBy('created_at', 'DESC')->firstOrFail();
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

            $cart = DenganSopirCart::where('id', $request->cart_id)->firstOrFail();
            // dd($cart);

            if(empty($cart->customer_name)){
				return redirect()->back()->withErrors(['msg' => 'payments/failed?']);
            }

            if(!empty($cart->kembali_id && $cart->lokasi_kembali)){
                    $kembali_id = $cart->kembali_id;
                    $lokasi_kembali = $cart->lokasi_kembali;  
                    $lokasi_kembali_lengkap = $cart->lokasi_kembali_lengkap;
  
            } else {
                $kembali_id = $cart->kembali_id ?? '';
                $lokasi_kembali = $cart->lokasi_kembali ?? '';
                $lokasi_kembali_lengkap = $cart->lokasi_kembali_lengkap ?? '';

            } 

            $dt = Carbon::now();
            // dd($cart);
            $order = Order::create([
                'user_id' => Auth::id(),
                'seller_id' => $cart->seller_id,
                'invoice' => rand(100000, 999999). '-' .$dt->year, //INVOICENYA KITA BUAT DARI STRING RANDOM DAN WAKTU
                'order_date' => $orderDate,
                'fitur' => 'v2',
                'payment_due' => $paymentDue,
                'payment_status' => Order::UNPAID,
                'wilayah' => $cart->wilayah,
                'addon_price' => $cart->addon_price,
                'addon_hari' => $cart->addon_hari,
                'biaya_aplikasi' => $cart->biaya_aplikasi,
                'jemput_id' => $cart->jemput_id,
                'lokasi_jemput' => $cart->lokasi_jemput,
                'lokasi_jemput_lengkap' => $cart->lokasi_jemput_lengkap,
                'kembali_id' => $kembali_id,
                'lokasi_kembali' => $lokasi_kembali,
                'lokasi_kembali_lengkap' => $lokasi_kembali_lengkap,
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
            $this->_OrderEmail($order);
            // dd($order);

            // create coupon transaksi

            // delete cart
            if($order){
                DenganSopirCart::where('id', $cart->id)->delete();
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
