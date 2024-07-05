<?php

namespace App\Http\Controllers\Seller;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Province;
use App\Models\ProductName;
use App\Models\ProductCar;


class SellerProductController extends Controller
{


    public function index()
    {
        $product = Product::with(['seller'])->where('seller_id', Auth::guard('seller')->id())->orderBy('created_at', 'DESC')
        ->get();
        
        $province = Province::orderBy('created_at', 'DESC')->get();

        $seller = ProductCar::orderBy('created_at', 'DESC')->where('seller_id', Auth::guard('seller')->id())->get();

        return view('seller.product.table')->with([
            'product' => $product,
            'province' => $province,
            'seller' => $seller,
        ]);
    }


    public function store(Request $request)
    {

        // Handle the user upload of avatar
        $request->validate([
            'name' => 'required',
            'jenis' => 'required',
            'status' => 'required',
            'wilayah' => 'required',
            'bagasi' => 'required',
            'kursi' => 'required',
            'stock' => 'required',
            'price' => 'required',
        ]);

            $product = Product::create([
                'seller_id' => Auth::guard('seller')->id(),
                'name' => $request->name,
                'jenis' => $request->jenis,
                'wilayah' => $request->wilayah,
                'bagasi' => $request->bagasi,
                'kursi' => $request->kursi,
                'stock' => $request->stock,
                'price' => $request->price,
                'status' => $request->status,
            ]);
            // dd($product);

     return redirect(route('productm.index'))->with(['success' => 'Product Baru Ditambahkan']);
     
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $province = Province::orderBy('created_at', 'DESC')->get();
        $seller = ProductName::orderBy('created_at', 'DESC')->where('seller_id', Auth::guard('seller')->id())->get();

        return view('seller.product.edit')->with([
            'product' => $product,
            'province' => $province,
            'seller' => $seller,
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
        
        // Handle the user upload of avatar
        $request->validate([
            'name' => 'required',
            'jenis' => 'required',
            'status' => 'required',
            'wilayah' => 'required',
            'bagasi' => 'required',
            'kursi' => 'required',
            'stock' => 'required',
            'price' => 'required',
        ]);

        $product = Product::find($id);

            $product->update([
                'seller_id' => Auth::guard('seller')->id(),
                'name' => $request->name,
                'jenis' => $request->jenis,
                'wilayah' => $request->wilayah,
                'bagasi' => $request->bagasi,
                'kursi' => $request->kursi,
                'stock' => $request->stock,
                'price' => $request->price,
                'status' => $request->status,
            ]);
        
         return redirect(route('productm.index'))->with(['success' => 'Product Baru Ditambahkan']);

    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect(route('productm.index'))->with(['success' => 'Produk Sudah Dihapus']);
    }

}