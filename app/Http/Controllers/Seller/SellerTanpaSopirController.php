<?php

namespace App\Http\Controllers\Seller;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\TanpaSopir;
use App\Models\Province;
use App\Models\ProductName;
use App\Models\ProductCar;


class SellerTanpaSopirController extends Controller
{


    public function index()
    {
        $product = TanpaSopir::with(['seller'])->where('seller_id', Auth::guard('seller')->id())->orderBy('created_at', 'DESC')
        ->get();
        
        $province = Province::orderBy('created_at', 'DESC')->get();

        $seller = ProductCar::orderBy('created_at', 'DESC')->where('seller_id', Auth::guard('seller')->id())->get();

        return view('seller.tanpasopir.table')->with([
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

            $product = TanpaSopir::create([
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

     return redirect(route('tanpasopirm.index'))->with(['success' => 'Product Baru Ditambahkan']);
     
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = TanpaSopir::find($id);
        $province = Province::orderBy('created_at', 'DESC')->get();

        return view('seller.tanpasopir.edit')->with([
            'product' => $product,
            'province' => $province,
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

        $product = TanpaSopir::find($id);

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
        
         return redirect(route('tanpasopirm.index'))->with(['success' => 'Product Baru Ditambahkan']);

    }

    public function destroy($id)
    {
        $product = TanpaSopir::find($id);
        $product->delete();
        return redirect(route('tanpasopirm.index'))->with(['success' => 'Produk Sudah Dihapus']);
    }

}