<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\ProductCar;
use App\Models\Seller;
use App\Models\ProductName;

use Image;

class ProductCarController extends Controller
{

    public function index()
    {
        $car = ProductCar::orderBy('created_at', 'DESC')->get();
        $seller = Seller::orderBy('created_at', 'DESC')->get();
        $names = ProductName::orderBy('created_at', 'DESC')->get();

        return view('admin.car.table')->with([
            'names' => $names,
            'car' => $car,
            'seller' => $seller,
        ]);
    }

    public function store(Request $request)
    {

        // Handle the user upload of avatar
        $request->validate([
            'productname_id' => 'required',
            'seller_id' => 'required',
        ]);


            $car = ProductCar::create([
                'productname_id' => $request->productname_id,
                'seller_id' => $request->seller_id,
            ]);
            // dd($product);

     return redirect(route('productcar.index'))->with(['success' => 'Product Baru Ditambahkan']);
     
     }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $car = ProductCar::find($id);
        $names = ProductName::orderBy('created_at', 'DESC')->get();
        $seller = Seller::orderBy('created_at', 'DESC')->get();
        return view('admin.car.edit')->with([
            'car' => $car,
            'names' => $names,
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
            'productname_id' => 'required',
            'seller_id' => 'required',
        ]);

        $car = ProductCar::find($id);

            $car->update([
                'productname_id' => $request->productname_id,
                'seller_id' => $request->seller_id,
            ]);
        
         return redirect(route('productcar.index'))->with(['success' => 'Product Baru Ditambahkan']);

    }

    public function destroy($id)
    {
        $car = ProductCar::find($id);
        $car->delete();
        return redirect(route('productcar.index'))->with(['success' => 'Produk Sudah Dihapus']);
    }

}