<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Province;
use Illuminate\Support\Str;

class CityController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $city = City::orderBy('created_at', 'DESC')
        ->get();

        $province = Province::orderBy('created_at', 'DESC')
            ->whereIn('id', [6, 3, 9])
            ->get();

        return view('admin.city.table')->with([
            'city' => $city,
            'province' => $province,

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
            'city_name' => 'required',
            'type' => 'required',
            'postal_code' => 'required',
        ]);

        $city = City::create([
            'province_id' => $request->province_id,
            'city_name' => $request->city_name,
            'type' => $request->type,
            'postal_code' => $request->postal_code,
        ]);
        
     return redirect(route('city.index'))->with(['success' => 'Product Baru Ditambahkan']);
     
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
        $city = City::find($id);
        $province = Province::orderBy('created_at', 'DESC')
            ->whereIn('id', [6, 3, 9])
            ->get();
        return view('admin.city.edit')->with([
            'city' => $city,
            'province' => $province,

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
            'city_name' => 'required',
            'type' => 'required',
            'postal_code' => 'required',
        ]);

        $city = City::find($id);

        $city->update([
            'province_id' => $request->province_id,
            'city_name' => $request->city_name,
            'type' => $request->type,
            'postal_code' => $request->postal_code,
        ]);
        
         return redirect(route('city.index'))->with(['success' => 'Product Baru Ditambahkan']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\city  $city
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $city = City::find($id);
        $city->delete();
        return redirect(route('city.index'))->with(['success' => 'Produk Sudah Dihapus']);
    }

}