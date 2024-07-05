<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\ProductName;

class ProductNameController extends Controller
{

    public function index()
    {
        $names = ProductName::orderBy('created_at', 'DESC')->get();

        return view('admin.names.table')->with([
            'names' => $names,
        ]);
    }

    public function store(Request $request)
    {

        // Handle the user upload of avatar
        $request->validate([
            'name' => 'required',
        ]);


            $names = ProductName::create([
                'name' => $request->name,
            ]);
            // dd($product);

     return redirect(route('productname.index'))->with(['success' => 'Product Baru Ditambahkan']);
     
     }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $names = ProductName::find($id);
        return view('admin.names.edit')->with([
            'names' => $names,
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
        ]);

        $names = ProductName::find($id);

            $names->update([
                'name' => $request->name,
            ]);
        
         return redirect(route('productname.index'))->with(['success' => 'Product Baru Ditambahkan']);

    }

    public function destroy($id)
    {
        $names = ProductName::find($id);
        $names->delete();
        return redirect(route('productname.index'))->with(['success' => 'Produk Sudah Dihapus']);
    }

}