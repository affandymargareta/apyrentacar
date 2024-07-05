<?php

namespace App\Http\Controllers\Seller;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Session;
use App\Models\Seller;
use App\Models\Product;
use App\Models\User;
use App\Models\CityPrice;
use App\Models\City;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class SellerOrderController extends Controller
{

    public function index()
    {
        $order = Order::with(['seller'])->where('seller_id', Auth::guard('seller')->id())->where('payment_status', 'paid')->orderBy('created_at', 'DESC')
        ->get();
        
        return view('seller.order.table')->with([
            'order' => $order,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\contact  $contact
     * @return \Illuminate\Http\Response
     */

     public function show($id)
     {
        
        $order = Order::find($id);

        $jemputCity = City::orderBy('created_at', 'DESC')->where('id', $order->lokasi_jemput)->first();
        $kembaliCity = City::orderBy('created_at', 'DESC')->where('id', $order->lokasi_kembali)->first();

        $totalHari = $order->durasi -1;
        $durasi = date_create($order->mulai)->modify("+ {$totalHari} days")->format("D, d F Y");



        if($order->product->wilayah != $order->jemput_id) {
            $jemput = CityPrice::where('province_id', $order->jemput_id)->where('product_id', $order->product->name)->first();
            $jemputPrice = $jemput->price ?? '';
            $jemputzona = $jemput->zona ?? '';
        } else {
            $jemputPrice = 0;
            $jemputzona = '';
        }

        if(!empty($order->kembali_id)){

            if($order->product->wilayah != $order->kembali_id) {
                $Kembali = CityPrice::where('province_id', $order->kembali_id)->where('product_id', $order->product->name)->first();
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

        return view('seller.order.show')->with([
            'order' => $order,
            'jemputCity' => $jemputCity,
            'kembaliCity' => $kembaliCity,
            'jemputPrice' => $jemputPrice,
            'jemputzona' => $jemputzona,
            'kembaliPrice' => $kembaliPrice,
            'Kembalizona' => $Kembalizona,
            'durasi' => $durasi,
            'addon_price' => $addon_price,

        ]);
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::find($id);
        return view('seller.order.edit')->with([
            'order' => $order,
        ]);
    }
        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'supir_name' => 'required',
            'supir_telpon' => 'required',
            'plat_nomer' => 'required',

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
            $Order = Order::find($id);

            $Order->update([
                'supir_name' => $request->supir_name,
                'supir_telpon' => $request->supir_telpon,
                'plat_nomer' => $request->plat_nomer,
            ]);


            // dd($order);
            $this->_OrderEmail($Order);
            // create coupon transaksi

            // delete cart
            if($Order){
                $product = Product::where('id', $Order->product_id)->first();
                $product->stock = $product->stock - 1;
                $product->save();
            }

            // $this->_saveShiping($order);

            DB::commit();

            //REDIRECT KE HALAMAN FINISH TRANSAKSI
            Session::flash('success', 'Thank you. Your order has been received!');
            return redirect(route('morder.index'))->with(['success' => 'Order Baru Ditambahkan']);

        } catch (\Exception $e) {
            //JIKA TERJADI ERROR, MAKA ROLLBACK DATANYA
            DB::rollback();
            dd($e);

            // DAN KEMBALI KE FORM TRANSAKSI SERTA MENAMPILKAN ERROR
            // return redirect()->back()->with(['error' => $e->getMessage()]);
        }
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
        $data["supir_name"]= $orderID->supir_name;
        $data["supir_telpon"]= $orderID->supir_telpon;
        $data["customer_email"]= $orderID->customer_email;
        $data["addon_price"]= $addon_price;
        $data["addon_hari"]= $addon_hari;
        $data["price"]= $orderID->price;


        $pdf = PDF::loadView('FrontEnd.user-invoice', $data)
        ->setPaper('a4', 'portrait')->setWarnings(false)
        ->setOptions(['dpi' => 250, 'isHtml5ParserEnabled' => true, 'defaultFont' => 'sans-serif']);
        
        // return $pdf->stream(rand(1,50). '.' . 'pdf');

        Mail::send('FrontEnd.user-email', $data, function($message)use($data, $pdf) {

            $message->to($data["customer_email"], $data["customer_email"])

                    ->subject($data["product_name"])

                    ->attachData($pdf->output(),'voucher'. '.' . 'pdf');

        });

     }

}