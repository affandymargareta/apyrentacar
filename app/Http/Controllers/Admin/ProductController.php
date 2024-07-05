<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Province;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Image;

class ProductController extends Controller
{

    public function index()
    {
        $product = Product::with('province')->orderBy('created_at', 'DESC')->get();

        $province = Province::orderBy('created_at', 'DESC')->get();

        return view('admin.product.table')->with([
            'product' => $product,
            'province' => $province,
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
        $product = Product::find($id);
        $province = Province::orderBy('created_at', 'DESC')->get();

        return view('admin.product.edit')->with([
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'jenis' => 'required',
            'status' => 'required',
            'wilayah' => 'required',
            'bagasi' => 'required',
            'kursi' => 'required',
            'stock' => 'required',
            'price' => 'required',
            'seller_id' => 'required',
        ]);

        $product = Product::find($id);


            $imageName = rand(1,50).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);

            $product->update([
                'seller_id' => $request->seller_id,
                'name' => $request->name,
                'jenis' => $request->jenis,
                'wilayah' => $request->wilayah,
                'bagasi' => $request->bagasi,
                'kursi' => $request->kursi,
                'stock' => $request->stock,
                'price' => $request->price,
                'image' => 'images/'.$imageName,
                'status' => $request->status,
            ]);
        
         return redirect(route('product.index'))->with(['success' => 'Product Baru Ditambahkan']);

    }

    public function destroy($id)
    {
        $product = Product::find($id);
        File::delete(storage_path('images/' . $product->image));
        $product->delete();
        return redirect(route('product.index'))->with(['success' => 'Produk Sudah Dihapus']);
    }

}