<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Image;

class CompanyController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $company = Company::orderBy('created_at', 'DESC')
        ->get();

        return view('admin.company.table', compact('company'));
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
            'name' => 'required',
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required',
        ]);

        $imageName = rand(1,50).'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('images'), $imageName);

            $company = Company::create([
                'name' => $request->name,
                'title' => $request->title,
                'description' => $request->description,
                'image' => 'images/'.$imageName,
            ]);
        
     return redirect(route('company.index'))->with(['success' => 'Product Baru Ditambahkan']);
     
     }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\company  $company
     * @return \Illuminate\Http\Response
     */

    public function show(blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\company  $company
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $company = Company::find($id);

        return view('admin.company.edit')->with([
            'company' => $company,
        ]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\company  $company
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        
        // Handle the user upload of avatar
        $request->validate([
            'name' => 'required',
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required',
        ]);

        $company = Company::find($id);


            $imageName = rand(1,50).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);

            $company->update([
                'name' => $request->name,
                'title' => $request->title,
                'description' => $request->description,
                'image' => 'images/'.$imageName,
            ]);
        
         return redirect(route('company.index'))->with(['success' => 'Product Baru Ditambahkan']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\company  $company
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $company = Company::find($id);
        File::delete(storage_path('images/' . $company->image));
        $company->delete();
        return redirect(route('company.index'))->with(['success' => 'Produk Sudah Dihapus']);
    }

}