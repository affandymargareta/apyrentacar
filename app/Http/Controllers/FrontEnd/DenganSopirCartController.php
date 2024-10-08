<?php

namespace App\Http\Controllers\FrontEnd;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\DenganSopirCart;
use App\Models\CityPrice;
use App\Models\DenganSopir;
use App\Models\Province;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;

class DenganSopirCartController extends Controller
{

    public function index()
    {
        $cart = DenganSopirCart::with('province')->orderBy('created_at', 'DESC')->get();

        $province = Province::orderBy('created_at', 'DESC')->get();

        return view('admin.cart.table')->with([
            'cart' => $cart,
            'province' => $province,
        ]);
    }


    public function store(Request $request)
    {

        // Handle the user upload of avatar
        // $request->validate([
        //     'wilayah' => 'required',
        //     'jemput_id' => 'required',
        //     'lokasi_jemput' => 'required',
        //     'mulai' => 'required',
        //     'akhir' => 'required',
        //     'durasi' => 'required',
        //     'jam_mulai' => 'required',
        //     'jam_akhir' => 'required',
        //     'product_id' => 'required',
        // ]);

        // dd($request->all());

        $product = DenganSopir::where('id', $request->product_id)->with(['province'])->firstOrFail();
        // Pisahkan jemput_id menjadi province_id dan city_id
        list($provinceId1, $cityId1) = explode(',', $request->jemput_id);

        if($product->wilayah != $provinceId1) {
            $JemputPrice = CityPrice::where('province_id', $provinceId1)->where('product_id', $product->name)->first();
            $JemputPrice1 = $JemputPrice->price;
        } else {
            $JemputPrice1 = 0;
        }

        list($provinceId2, $cityId2) = explode(',', $request->kembali_id);


        if(!empty($provinceId2)){

            if($product->wilayah != $provinceId2) {
                $KembaliPrice = CityPrice::where('province_id', $provinceId2)->where('product_id', $product->name)->first();
                $KembaliPrice2 = $KembaliPrice->price;
                $kembali_id = $provinceId2;
                $lokasi_kembali = $cityId2;
                $lokasi_kembali_lengkap = $request->lokasi_kembali_lengkap;
            } else {
                $KembaliPrice2 = 0;
                $kembali_id = $provinceId2 ?? '';
                $lokasi_kembali = $cityId2 ?? '';
                $lokasi_kembali_lengkap = $request->lokasi_kembali_lengkap ?? '';
            }

        }else {
            $KembaliPrice2 = 0;
            $kembali_id = $provinceId2 ?? '';
            $lokasi_kembali = $cityId2 ?? '';
            $lokasi_kembali_lengkap = $request->lokasi_kembali_lengkap ?? '';
        }


		if(!empty($request->addon_hari)){
            $addonprice = $product->addOn->addon_price;
        }else {
            $addonprice = 0;
        }

        $addon_price = ($product->addOn->addon_price ?? 0) * $request->addon_hari;


        // dd($request->all(), $JemputPrice1, $product->price, $KembaliPrice2);
        $total = ($product->price * $request->durasi) + ($JemputPrice1 * $request->durasi) + ($KembaliPrice2 * $request->durasi) + $request->biaya_aplikasi + $addon_price;

        // dd($request->all(), $total);

        // dd($total);

            $cart = DenganSopirCart::create([
                'seller_id' => $product->seller_id,
                'user_id' => Auth::id(),
                'wilayah' => $request->wilayah,
                'addon_price' => $addonprice,
                'addon_hari' => $request->addon_hari,
                'biaya_aplikasi' => $request->biaya_aplikasi,
                'jemput_id' => $provinceId1,
                'lokasi_jemput' =>  $cityId1,
                'lokasi_jemput_lengkap' => $request->lokasi_jemput_lengkap,
                'kembali_id' => $kembali_id,
                'lokasi_kembali' => $lokasi_kembali,
                'lokasi_kembali_lengkap' => $lokasi_kembali_lengkap,
                'mulai' => $request->mulai,
                'akhir' => $request->akhir,
                'durasi' => $request->durasi,
                'jam_mulai' => $request->jam_mulai,
                'jam_akhir' => $request->jam_akhir,
                'product_id' => $product->id,
                'price' => $total,
            ]);
        // dd($request->all());

            // dd($cart);

            // dd($product);

     return redirect(route('booking2', $cart->id))->with(['success' => 'Product Baru Ditambahkan']);
     
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
        
        // Handle the user upload of avatar
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required',
            'customer_telpon' => 'required',
            'customer_email' => 'required',

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        // dd($request->all(),$id);

            $cart = DenganSopirCart::find($id);

            $cart->update([
                'customer_name' => $request->customer_name,
                'customer_telpon' => $request->customer_telpon,
                'customer_email' => $request->customer_email,
            ]);
        
            if($cart){
                $customer = Customer::create([
                    'customer_name' => $request->customer_name,
                    'customer_telpon' => $request->customer_telpon,
                    'customer_email' => $request->customer_email,
                ]);
            }
            // dd($cart);


         return redirect(route('booking2', $cart->id))->with(['success' => 'Product Baru Ditambahkan']);

    }

    public function destroy($id)
    {
        $cart = DenganSopirCart::find($id);
        $cart->delete();
        return redirect(route('cart.index'))->with(['success' => 'Produk Sudah Dihapus']);
    }

}