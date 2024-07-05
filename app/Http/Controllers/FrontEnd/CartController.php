<?php

namespace App\Http\Controllers\FrontEnd;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CityPrice;
use App\Models\Product;
use App\Models\Province;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{

    public function index()
    {
        $cart = Cart::with('province')->orderBy('created_at', 'DESC')->get();

        $province = Province::orderBy('created_at', 'DESC')->get();

        return view('admin.cart.table')->with([
            'cart' => $cart,
            'province' => $province,
        ]);
    }


    public function store(Request $request)
    {

        // Handle the user upload of avatar
        $request->validate([
            'wilayah' => 'required',
            'jemput_id' => 'required',
            'lokasi_jemput' => 'required',
            'mulai' => 'required',
            'durasi' => 'required',
            'jam' => 'required',
            'product_id' => 'required',
        ]);

        // dd($request->all());

        $product = Product::where('id', $request->product_id)->with(['province'])->firstOrFail();

        if($product->wilayah != $request->jemput_id) {
            $JemputPrice = CityPrice::where('province_id', $request->jemput_id)->where('product_id', $product->name)->first();
            $JemputPrice1 = $JemputPrice->price;
        } else {
            $JemputPrice1 = 0;
        }

        if(!empty($request->kembali_id)){

            if($product->wilayah != $request->kembali_id) {
                $KembaliPrice = CityPrice::where('province_id', $request->kembali_id)->where('product_id', $product->name)->first();
                $KembaliPrice2 = $KembaliPrice->price;
                $kembali_id = $request->kembali_id;
                $lokasi_kembali = $request->lokasi_kembali;
            } else {
                $KembaliPrice2 = 0;
                $kembali_id = $request->kembali_id ?? '';
                $lokasi_kembali = $request->lokasi_kembali ?? '';
            }

        }else {
            $KembaliPrice2 = 0;
            $kembali_id = $request->kembali_id ?? '';
            $lokasi_kembali = $request->lokasi_kembali ?? '';
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

            $cart = Cart::create([
                'seller_id' => $product->seller_id,
                'user_id' => Auth::id(),
                'wilayah' => $request->wilayah,
                'addon_price' => $addonprice,
                'addon_hari' => $request->addon_hari,
                'biaya_aplikasi' => $request->biaya_aplikasi,
                'jemput_id' => $request->jemput_id,
                'lokasi_jemput' => $request->lokasi_jemput,
                'kembali_id' => $kembali_id,
                'lokasi_kembali' => $lokasi_kembali,
                'mulai' => $request->mulai,
                'durasi' => $request->durasi,
                'jam_mulai' => $request->jam,
                'jam_akhir' => '23:59',
                'product_id' => $product->id,
                'price' => $total,
            ]);

            // dd($cart);

            // dd($product);

     return redirect(route('booking', $cart->id))->with(['success' => 'Product Baru Ditambahkan']);
     
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

            $cart = Cart::find($id);

            $cart->update([
                'customer_name' => $request->customer_name,
                'customer_telpon' => $request->customer_telpon,
                'customer_email' => $request->customer_email,
            ]);
        
            // dd($cart);


         return redirect(route('booking', $cart->id))->with(['success' => 'Product Baru Ditambahkan']);

    }

    public function destroy($id)
    {
        $cart = Cart::find($id);
        $cart->delete();
        return redirect(route('cart.index'))->with(['success' => 'Produk Sudah Dihapus']);
    }

}