<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\ProductImage;
use App\Models\ProductName;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Image;

class ProductImageController extends Controller
{

    public function index()
    {
        $images = ProductImage::orderBy('created_at', 'DESC')->get();
        $product = ProductName::orderBy('created_at', 'DESC')->get();

        return view('admin.images.table')->with([
            'images' => $images,
            'product' => $product,
        ]);
    }

    public function store(Request $request)
    {

        // Handle the user upload of avatar
        $request->validate([
            'product_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = rand(1,50).'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('images'), $imageName);

            $images = ProductImage::create([
                'product_id' => $request->product_id,
                'image' => 'images/'.$imageName,
            ]);
            // dd($product);

     return redirect(route('productimage.index'))->with(['success' => 'Product Baru Ditambahkan']);
     
     }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = ProductImage::find($id);
        $product = ProductName::orderBy('created_at', 'DESC')->get();

        return view('admin.images.edit')->with([
            'images' => $images,
            'product' => $product,

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
            'product_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $images = ProductImage::find($id);


            $imageName = rand(1,50).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);

            $images->update([
                'product_id' => $request->product_id,
                'image' => 'images/'.$imageName,
            ]);
        
         return redirect(route('productimage.index'))->with(['success' => 'Product Baru Ditambahkan']);

    }

    public function destroy($id)
    {
        $images = ProductImage::find($id);
        File::delete(storage_path('images/' . $images->image));
        $images->delete();
        return redirect(route('productimage.index'))->with(['success' => 'Produk Sudah Dihapus']);
    }

}