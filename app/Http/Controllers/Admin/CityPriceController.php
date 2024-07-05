<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\CityPrice;
use Illuminate\Support\Str;
use App\Models\Province;
use App\Models\ProductName;

class CityPriceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $city = CityPrice::orderBy('created_at', 'DESC')
        ->get();

        $province = Province::orderBy('created_at', 'DESC')->get();
        $product = ProductName::orderBy('created_at', 'DESC')->get();

        return view('admin.cityprice.table')->with([
            'city' => $city,
            'province' => $province,
            'product' => $product,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        //
    }

    public function store(Request $request)
    {

        // Handle the user upload of avatar
        $request->validate([
            'province_id' => 'required',
            'product_id' => 'required',
            'zona' => 'required',
            'price' => 'required',
        ]);

        $city = CityPrice::create([
            'province_id' => $request->province_id,
            'product_id' => $request->product_id,
            'zona' => $request->zona,
            'price' => $request->price,
        ]);
        
     return redirect(route('cityprice.index'))->with(['success' => 'Product Baru Ditambahkan']);
     
     }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\city  $city
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\city  $city
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $city = CityPrice::find($id);
        $province = Province::orderBy('created_at', 'DESC')->get();
        $product = ProductName::orderBy('created_at', 'DESC')->get();

        return view('admin.cityprice.edit')->with([
            'city' => $city,
            'province' => $province,
            'product' => $product,
        ]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\city  $city
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        
        // Handle the user upload of avatar
        $request->validate([
            'province_id' => 'required',
            'product_id' => 'required',
            'zona' => 'required',
            'price' => 'required',
        ]);

        $city = CityPrice::find($id);

        $city->update([
            'province_id' => $request->province_id,
            'product_id' => $request->product_id,
            'zona' => $request->zona,
            'price' => $request->price,
        ]);
        
         return redirect(route('cityprice.index'))->with(['success' => 'Product Baru Ditambahkan']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\city  $city
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $city = CityPrice::find($id);
        $city->delete();
        return redirect(route('cityprice.index'))->with(['success' => 'Produk Sudah Dihapus']);
    }

}