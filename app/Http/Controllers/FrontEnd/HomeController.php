<?php

namespace App\Http\Controllers\FrontEnd;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\City;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Blog;
use App\Models\Company;
use App\Models\CityPrice;
use App\Models\Cart;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Order;
use App\Models\User;
use App\Models\Seller;
use App\Models\AddOn;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
// use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Product.
     */
    public function index()
    {   
        $province = City::orderBy('created_at', 'DESC')->get();

        $Banner = Banner::orderBy('created_at', 'DESC')->get();

        $product = Product::orderBy('created_at', 'DESC')->get();

        $blog = Blog::orderBy('created_at', 'DESC')->get();

        $company = Company::orderBy('created_at', 'DESC')->where(['id' => '1'])->get();


        return view('FrontEnd.home')->with([
        'province' => $province,
        'Banner' => $Banner,
        'product' => $product,
        'blog' => $blog,
        'company' => $company,
        ]);
    }
 
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function CategorySearch(Request $request)
    {
        //

        $city = City::where('city_name', $request->wilayah)->firstOrFail();
        $province =$city->province;

        $product = Product::where('wilayah',$province->id)->where('status', 1)->get();
 
        $search = ['wilayah' => $request->wilayah, 'mulai' => $request->mulai, 'durasi' => $request->durasi,'jam' => $request->jam,];
 
        $totalHari = $request->durasi -1;

        $durasi = date_create($request->mulai)->modify("+ {$totalHari} days")->format("D, d F Y");
        
        return view('FrontEnd.category')->with([
            'Product' => $product,
            'search' => $search,
            'durasi' => $durasi
        ]);
    }

    public function getCitys1()
    {
        $cities = City::where('province_id', request()->jemput_id)->get();
        return response()->json(['status' => 'success', 'data' => $cities]);
    }

    public function getCitys2()
    {
        $cities = City::where('province_id', request()->kembali_id)->get();
        return response()->json(['status' => 'success', 'data' => $cities]);
    }

    public function getCityPrice1()
    {

        $cities = CityPrice::where('province_id', request()->jemput_id)->where('product_id', request()->product_id)->get();
        return response()->json(['status' => 'success', 'data' => $cities]);
    }
    public function getCityPrice2()
    {

        $cities = CityPrice::where('province_id', request()->kembali_id)->where('product_id', request()->product_id)->get();
        return response()->json(['status' => 'success', 'data' => $cities]);
    }

    public function CarDetail(Request $request, $id)
    {

        $provinces = Province::orderBy('province', 'DESC')->get();

        $product = Product::where('id', $id)->where('status', 1)->firstOrFail();
        
        $search = ['wilayah' => $request->wilayah, 'mulai' => $request->mulai, 'durasi' => $request->durasi,'jam' => $request->jam,];
 
        $totalHari = $request->durasi -1;

        $durasi = date_create($request->mulai)->modify("+ {$totalHari} days")->format("D, d F Y");

        $addon = AddOn::orderBy('created_at', 'DESC')->where('product_id', $product->name)->first();


        return view('FrontEnd.car-detail')->with([
            'product' => $product,
            'search' => $search,
            'provinces' => $provinces,
            'durasi' => $durasi,
            'addon' => $addon,

        ]);
    }

    public function Companys()
    {   
        $company = Company::orderBy('created_at', 'DESC')->where(['id' => '1'])->get();

        return view('FrontEnd.company')->with([
            'company' => $company,

        ]);
    }
    public function Article()
    {   

        $blog = Blog::orderBy('created_at', 'DESC')->get();

        return view('FrontEnd.article')->with([
            'blog' => $blog,

        ]);
    }
    public function Services()
    {   
        return view('FrontEnd.services')->with([

        ]);
    }
    public function Contacts()
    {   
        return view('FrontEnd.contact')->with([

        ]);
    }
    public function Testimonis()
    {   
        return view('FrontEnd.testimoni')->with([

        ]);
    }
    public function Booking($id)
    {   

        $cart = Cart::where('id', $id)->firstOrFail();

        $totalHari = $cart->durasi -1;

        $durasi = date_create($cart->mulai)->modify("+ {$totalHari} days")->format("D, d F Y");

        $kembaliCity = City::orderBy('created_at', 'DESC')->where('id', $cart->lokasi_kembali)->first();


        $jemputCity = City::orderBy('created_at', 'DESC')->where('id', $cart->lokasi_jemput)->first();

        $kembaliPrice = CityPrice::where('province_id', $cart->kembali_id)->where('product_id', $cart->product->name)->first();

        $jemputPrice = CityPrice::where('province_id', $cart->jemput_id)->where('product_id', $cart->product->name)->first();
        
        return view('FrontEnd.booking')->with([
            'cart' => $cart,
            'durasi' => $durasi,
            'kembaliCity' => $kembaliCity,
            'kembaliPrice' => $kembaliPrice,
            'jemputCity' => $jemputCity,
            'jemputPrice' => $jemputPrice,
        ]);
    }
    public function Checkout()
    {   
        return view('FrontEnd.checkout')->with([

        ]);
    }

    public function UserInvoice(Request $request)
    {   
        $orderID = Order::where('id', $request->order_id)->orderBy('created_at', 'DESC')->firstOrFail();
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
                $jemput = CityPrice::where('province_id', $orderID->kembali_id)->where('product_id', $product->name)->first();
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
        $data["price"]= $orderID->price;
        $data["orderID"]= $orderID->id;


        $pdf = PDF::loadView('FrontEnd.invoice2', $data)
        ->setPaper('a4', 'portrait')->setWarnings(false)
        ->setOptions(['dpi' => 250, 'isHtml5ParserEnabled' => true, 'defaultFont' => 'sans-serif']);
        
        return $pdf->stream(rand(1,50). '.' . 'pdf');

        // Mail::send('FrontEnd.email2', $data, function($message)use($data, $pdf) {

        //     $message->to($data["seller_email"], $data["seller_email"])

        //             ->subject($data["product_name"])

        //             ->attachData($pdf->output(),'voucher'. '.' . 'pdf');

        // });

        return redirect()->back()->with(['success' => 'Order Baru Ditambahkan']);

    }

    public function UserCar()
    {   
        $order = Order::where('user_id', Auth::id())->orderBy('created_at', 'DESC')->get();

        return view('FrontEnd.usercar')->with([
            'order' => $order,

        ]);
    }


    public function InvoiceDetail($id)
    {   
        $order = Order::where('id', $id)->orderBy('created_at', 'DESC')->firstOrFail();
        $user = User::where('id', $order->user_id)->first();
        $seller = Seller::where('id', $order->seller_id)->first();
        $product = Product::where('id', $order->product_id)->first();

        return view('FrontEnd.user-invoice2')->with([
            'order' => $order,
            'user' => $user,
            'seller' => $seller,
            'product' => $product,

        ]);
    }

}
