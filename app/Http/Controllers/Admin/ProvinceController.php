<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Province;
use Illuminate\Support\Str;

class ProvinceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $province = Province::orderBy('created_at', 'DESC')
        ->get();

        return view('admin.province.table', compact('province'));
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
            'province' => 'required',
        ]);

            $province = Province::create([
                'province' => $request->province,
            ]);
        
     return redirect(route('province.index'))->with(['success' => 'Product Baru Ditambahkan']);
     
     }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\province  $province
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\province  $province
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $province = Province::find($id);

        return view('admin.province.edit')->with([
            'province' => $province,
        ]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\province  $province
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        
        // Handle the user upload of avatar
        $request->validate([
            'province' => 'required',
        ]);

        $province = Province::find($id);

            $province->update([
                'province' => $request->province,
            ]);
        
         return redirect(route('province.index'))->with(['success' => 'Product Baru Ditambahkan']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\province  $province
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $province = Province::find($id);
        $province->delete();
        return redirect(route('province.index'))->with(['success' => 'Produk Sudah Dihapus']);
    }

}