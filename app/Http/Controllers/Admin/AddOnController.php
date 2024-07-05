<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductName;
use App\Models\AddOn;


class AddOnController extends Controller
{

    public function index()
    {
        $addon = AddOn::orderBy('created_at', 'DESC')->get();

        $product = ProductName::orderBy('created_at', 'DESC')->get();

        return view('admin.addon.table')->with([
            'addon' => $addon,
            'product' => $product,
        ]);
    }

    public function store(Request $request)
    {

        // Handle the user upload of avatar
        $request->validate([
            'product_id' => 'required',
            'addon_price' => 'required',
        ]);

            $addon = AddOn::create([
                'product_id' => $request->product_id,
                'addon_price' => $request->addon_price,
            ]);
            // dd($product);

     return redirect(route('addon.index'))->with(['success' => 'Product Baru Ditambahkan']);
     
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $addon = AddOn::find($id);
        $product = ProductName::orderBy('created_at', 'DESC')->get();

        return view('admin.addon.edit')->with([
            'product' => $product,
            'addon' => $addon,
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
            'addon_price' => 'required',
        ]);

        $addon = AddOn::find($id);

            $addon->update([
                'product_id' => $request->product_id,
                'addon_price' => $request->addon_price,
            ]);
        
         return redirect(route('addon.index'))->with(['success' => 'Product Baru Ditambahkan']);

    }

    public function destroy($id)
    {
        $addon = AddOn::find($id);
        $addon->delete();
        return redirect(route('addon.index'))->with(['success' => 'Produk Sudah Dihapus']);
    }

}