<?php

namespace App\Http\Controllers\FrontEnd;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\City;
use App\Models\Banner;
use App\Models\DenganSopir;
use App\Models\TanpaSopir;
use App\Models\Blog;
use App\Models\Company;
use App\Models\CityPrice;
use App\Models\TanpaSopirCart;
use App\Models\DenganSopirCart;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Order;
use App\Models\User;
use App\Models\Seller;
use App\Models\AddOn;
use Carbon\Carbon;
use App\Models\ProductName;

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
        // $province = Province::orderBy('created_at', 'DESC')->get();
        $province = Province::orderBy('created_at', 'DESC')
            ->whereIn('id', [6])
            ->get();

        $Banner = Banner::orderBy('created_at', 'DESC')->get();

        $product = DenganSopir::orderBy('created_at', 'DESC')->get();

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

     
    
    public function CategorySearch1(Request $request, $id)
    {

        $province = Province::where('province', $request->wilayah)->firstOrFail();
        $provinceId = $province->id;

        $sellers = Seller::whereHas('tanpaSopirs', function ($query) use ($id, $provinceId) {
            $query->where('name', $id)
                  ->where('wilayah', $provinceId)
                  ->where('status', 1)
                  ->orderBy('price', 'asc'); // Order by price in ascending order

        })->with(['tanpaSopirs' => function ($query) use ($id, $provinceId) {
            $query->where('name', $id)
                  ->where('wilayah', $provinceId)
                  ->where('status', 1)
                  ->orderBy('price', 'asc'); // Order by price in ascending order
        }])->get();
    
        
        $totalHari = $request->durasi;

        $akhir = date_create($request->mulai)->modify("+{$totalHari} days")->format('Y-m-d');

        $search = ['wilayah' => $request->wilayah, 'mulai' => $request->mulai, 'akhir' => $akhir,'jam_mulai' => $request->jam_mulai,'jam_akhir' => $request->jam_akhir];

        return view('FrontEnd.category1')->with([
            'sellers' => $sellers,
            'search' => $search,
            'totalHari' => $totalHari,
        ]);
    }
    
    public function CategorySearch2(Request $request, $id)
    {

        $province = Province::where('province', $request->wilayah)->firstOrFail();
        $provinceId = $province->id;
        
        $sellers = Seller::whereHas('denganSopirs', function ($query) use ($id, $provinceId) {
            $query->where('name', $id)
                  ->where('wilayah', $provinceId)
                  ->where('status', 1)
                  ->orderBy('price', 'asc'); // Order by price in ascending order

        })->with(['denganSopirs' => function ($query) use ($id, $provinceId) {
            $query->where('name', $id)
                  ->where('wilayah', $provinceId)
                  ->where('status', 1)
                  ->orderBy('price', 'asc'); // Order by price in ascending order
        }])->get();

        // Ambil durasi dalam hari dari request
        $totalHari = $request->durasi -1;

        $akhir = date_create($request->mulai)->modify("+{$totalHari} days")->format('Y-m-d');

        $search = ['wilayah' => $request->wilayah, 'mulai' => $request->mulai, 'akhir' => $akhir,'jam_mulai' => $request->jam_mulai,'jam_akhir' => $request->jam_akhir];
        
        $Hari = $request->durasi;

        return view('FrontEnd.category2')->with([
            'sellers' => $sellers,
            'search' => $search,
            'Hari' => $Hari
        ]);
    }

    public function ProvidedSearch1(Request $request)
    {
        $request->validate([
            'wilayah' => 'required',
            'mulai' => 'required',
            'durasi' => 'required',
            'jam_mulai' => 'required',
            'jam_akhir' => 'required',
        ]);
        // Retrieve the city and province
        $province = Province::where('province', $request->wilayah)->firstOrFail();
        $provinceId = $province->id;
        // Retrieve all product names
        $productNames = ProductName::all();

        // Create an array to store the result
        $result = [];

        foreach ($productNames as $productName) {
            // Get the product with the lowest price for each product name
            $lowestPricedProduct = TanpaSopir::where('name', $productName->id)
                ->when($provinceId, function ($query, $provinceId) {
                    return $query->where('wilayah', $provinceId);
                })
                ->where('status', 1)
                ->orderBy('price', 'asc')
                ->first();

            if ($lowestPricedProduct) {
                $result[] = [
                    'product_name' => $productName->name,
                    'name_id' => $productName->id,
                    'lowest_priced_product' => $lowestPricedProduct,
                ];
            }
        }

        // Ambil durasi dalam hari dari request
        $totalHari = $request->durasi;

        $akhir = date_create($request->mulai)->modify("+{$totalHari} days")->format('Y-m-d');

        $search = ['wilayah' => $request->wilayah, 'mulai' => $request->mulai, 'akhir' => $akhir,'jam_mulai' => $request->jam_mulai,'jam_akhir' => $request->jam_akhir];

        return view('FrontEnd.provided1')->with([
            'names' => $result,
            'search' => $search,
            'totalHari' => $totalHari,
        ]);
    }
    public function ProvidedSearch2(Request $request)
    {
        $request->validate([
            'wilayah' => 'required',
            'mulai' => 'required',
            'durasi' => 'required',
            'jam_mulai' => 'required',
            'jam_akhir' => 'required',
        ]);
        // Retrieve the city and province
        $province = Province::where('province', $request->wilayah)->firstOrFail();
        $provinceId = $province->id;
        // Retrieve all product names
        $productNames = ProductName::all();

        // Create an array to store the result
        $result = [];

        foreach ($productNames as $productName) {
            // Get the product with the lowest price for each product name
            $lowestPricedProduct = DenganSopir::where('name', $productName->id)
                ->when($provinceId, function ($query, $provinceId) {
                    return $query->where('wilayah', $provinceId);
                })
                ->where('status', 1)
                ->orderBy('price', 'asc')
                ->first();

            if ($lowestPricedProduct) {
                $result[] = [
                    'product_name' => $productName->name,
                    'name_id' => $productName->id,
                    'lowest_priced_product' => $lowestPricedProduct,
                ];
            }
        }

        // Ambil durasi dalam hari dari request
        $totalHari = $request->durasi -1;

        $akhir = date_create($request->mulai)->modify("+{$totalHari} days")->format('Y-m-d');

        $search = ['wilayah' => $request->wilayah, 'mulai' => $request->mulai, 'akhir' => $akhir,'jam_mulai' => $request->jam_mulai,'jam_akhir' => $request->jam_akhir];
        
        $Hari = $request->durasi;

        return view('FrontEnd.provided2')->with([
            'names' => $result,
            'search' => $search,
            'Hari' => $Hari
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

        $cities = CityPrice::where('province_id', request()->provinces1_id)->where('product_id', request()->product_id)->get();
        return response()->json(['status' => 'success', 'data' => $cities]);
    }
    public function getCityPrice2()
    {

        $cities = CityPrice::where('province_id', request()->provinces2_id)->where('product_id', request()->product_id)->get();
        return response()->json(['status' => 'success', 'data' => $cities]);
    }

    public function CarDetail1(Request $request, $id)
    {

        $product = TanpaSopir::where('id', $id)->where('status', 1)->firstOrFail();

        $durasi = $request->durasi;

        $akhir = date_create($request->mulai)->modify("+{$durasi} days")->format('Y-m-d');

        $search = ['wilayah' => $request->wilayah, 'mulai' => $request->mulai, 'akhir' => $akhir,'jam_mulai' => $request->jam_mulai,'jam_akhir' => $request->jam_akhir];


        return view('FrontEnd.tanpa-supir')->with([
            'product' => $product,
            'search' => $search,
            'durasi' => $durasi
        ]);
    }
    public function CarDetail2(Request $request, $id)
    {

        // $provinces = Province::orderBy('province', 'DESC')->get();
        
        $provinces = Province::orderBy('created_at', 'DESC')
            ->whereIn('id', [6, 3, 9])
            ->get();

        $city = City::orderBy('created_at', 'DESC')
        ->whereIn('province_id', [6, 3, 9])
        ->get();

        $product = DenganSopir::where('id', $id)->where('status', 1)->firstOrFail();


        $totalHari = $request->durasi -1;

        $akhir = date_create($request->mulai)->modify("+{$totalHari} days")->format('Y-m-d');

        $search = ['wilayah' => $request->wilayah, 'mulai' => $request->mulai, 'akhir' => $akhir,'jam_mulai' => $request->jam_mulai,'jam_akhir' => $request->jam_akhir];
        
        $durasi = $request->durasi;

        $addon = AddOn::orderBy('created_at', 'DESC')->where('product_id', $product->name)->first();

        return view('FrontEnd.dengan-supir')->with([
            'product' => $product,
            'search' => $search,
            'provinces' => $provinces,
            'durasi' => $durasi,
            'addon' => $addon,
            'city' => $city,

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
    
    public function Booking1($id)
    {   

        $cart = TanpaSopirCart::where('id', $id)->firstOrFail();
        
        return view('FrontEnd.booking1')->with([
            'cart' => $cart,
        ]);
    }

    public function Booking2($id)
    {   

        $cart = DenganSopirCart::where('id', $id)->firstOrFail();

        $kembaliCity = City::orderBy('created_at', 'DESC')->where('id', $cart->lokasi_kembali)->first();

        $jemputCity = City::orderBy('created_at', 'DESC')->where('id', $cart->lokasi_jemput)->first();

        $kembaliPrice = CityPrice::where('province_id', $cart->kembali_id)->where('product_id', $cart->dengansopir->name)->first();

        $jemputPrice = CityPrice::where('province_id', $cart->jemput_id)->where('product_id', $cart->dengansopir->name)->first();
        
        return view('FrontEnd.booking2')->with([
            'cart' => $cart,
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

    public function UserInvoice1(Request $request)
    {   
        $orderID = Order::where('id', $request->order_id)->orderBy('created_at', 'DESC')->firstOrFail();
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
        $data["price"]= $orderID->price;
        $data["opration1"]= "carengibran@gmail.com";
        $data["opration2"]= "carengibran@gmail.com";

        $pdf = PDF::loadView('FrontEnd.user-invoice-v1', $data)
        ->setPaper('a4', 'portrait')->setWarnings(false)
        ->setOptions(['dpi' => 250, 'isHtml5ParserEnabled' => true, 'defaultFont' => 'sans-serif']);
        
        // return $pdf->stream(rand(1,50). '.' . 'pdf');

          // Send email with PDF attachment
        Mail::send('FrontEnd.user-email-v1', $data, function($message) use ($data, $pdf) {
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

        // return redirect()->back()->with(['success' => 'Order Baru Ditambahkan']);

    }

    public function UserInvoice2(Request $request)
    {   
        $orderID = Order::where('id', $request->order_id)->orderBy('created_at', 'DESC')->firstOrFail();
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


        $kembalibanding = Province::orderBy('created_at', 'DESC')->where('province', $orderID->wilayah)->first();

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
        $data["supir_name"]= $orderID->supir_name;
        $data["supir_telpon"]= $orderID->supir_telpon;
        $data["customer_email"]= $orderID->customer_email;
        $data["addon_price"]= $addon_price;
        $data["addon_hari"]= $addon_hari;
        $data["price"]= $orderID->price;
        $data["opration1"]= "carengibran@gmail.com";
        $data["opration2"]= "carengibran@gmail.com";

        $pdf = PDF::loadView('FrontEnd.user-invoice-v2', $data)
        ->setPaper('a4', 'portrait')->setWarnings(false)
        ->setOptions(['dpi' => 250, 'isHtml5ParserEnabled' => true, 'defaultFont' => 'sans-serif']);
        
        // return $pdf->stream(rand(1,50). '.' . 'pdf');

        // Send email with PDF attachment
        Mail::send('FrontEnd.user-email-v2', $data, function($message) use ($data, $pdf) {
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

        // return redirect()->back()->with(['success' => 'Order Baru Ditambahkan']);

    }

    public function UserInvoice3(Request $request)
    {   
        $orderID = Order::where('id', $request->order_id)->orderBy('created_at', 'DESC')->firstOrFail();
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


        // return redirect()->back()->with(['success' => 'Order Baru Ditambahkan']);
    }

    public function UserInvoice4(Request $request)
    {   
        $orderID = Order::where('id', $request->order_id)->orderBy('created_at', 'DESC')->firstOrFail();

        if(!empty($orderID->lokasi_jemput)){
            $jemputCitys = $jemputCity->city_name;
			$lokasi_jemput_lengkap = $orderID->lokasi_jemput_lengkap;
        }else {
            $jemputCitys = '';
			$lokasi_jemput_lengkap  = '';
        }

        $user = User::where('id', $orderID->user_id)->first();
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

        $kembalibanding = Province::orderBy('created_at', 'DESC')->where('province', $orderID->wilayah)->first();

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
        $data["opration1"]= "carengibran@gmail.com";
        $data["opration2"]= "carengibran@gmail.com";

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

        // return redirect()->back()->with(['success' => 'Order Baru Ditambahkan']);

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
