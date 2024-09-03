<?php

namespace App\Http\Controllers\FrontEnd;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\TanpaSopirCart;
use App\Models\TanpaSopir;
use App\Models\Province;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;

class TanpaSopirCartController extends Controller
{

    public function index()
    {
        $cart = TanpaSopirCart::with('province')->orderBy('created_at', 'DESC')->get();

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
            'mulai' => 'required',
            'akhir' => 'required',
            'durasi' => 'required',
            'jam_mulai' => 'required',
            'jam_akhir' => 'required',
            'product_id' => 'required',
        ]);

        // dd($request->all());

        $product = TanpaSopir::where('id', $request->product_id)->with(['province'])->firstOrFail();

        // dd($request->all(), $JemputPrice1, $product->price, $KembaliPrice2);
        $total = ($product->price * $request->durasi)  + $request->biaya_aplikasi;

        // dd($request->all(), $total);

        // dd($total);

            $cart = TanpaSopirCart::create([
                'seller_id' => $product->seller_id,
                'user_id' => Auth::id(),
                'wilayah' => $request->wilayah,
                'biaya_aplikasi' => $request->biaya_aplikasi,
                'mulai' => $request->mulai,
                'akhir' => $request->akhir,
                'durasi' => $request->durasi,
                'jam_mulai' => $request->jam_mulai,
                'jam_akhir' => $request->jam_akhir,
                'product_id' => $product->id,
                'price' => $total,
            ]);

            // dd($cart);

            // dd($product);

     return redirect(route('booking1', $cart->id))->with(['success' => 'Product Baru Ditambahkan']);
     
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

            $cart = TanpaSopirCart::find($id);

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


         return redirect(route('booking1', $cart->id))->with(['success' => 'Product Baru Ditambahkan']);

    }

    public function destroy($id)
    {
        $cart = TanpaSopirCart::find($id);
        $cart->delete();
        return redirect(route('cart.index'))->with(['success' => 'Produk Sudah Dihapus']);
    }

}