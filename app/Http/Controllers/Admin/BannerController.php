<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Image;

class BannerController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $Banner = Banner::orderBy('created_at', 'DESC')
        ->get();

        return view('admin.banner.table', compact('Banner'));
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required',
        ]);

        $imageName = rand(1,50).'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('images'), $imageName);

            $Banner = Banner::create([
                'name' => $request->name,
                'description' => $request->description,
                'image' => 'images/'.$imageName,
            ]);
        
     return redirect(route('banner.index'))->with(['success' => 'Product Baru Ditambahkan']);
     
     }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\banner  $banner
     * @return \Illuminate\Http\Response
     */

    public function show(blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\banner  $banner
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $banner = Banner::find($id);

        return view('admin.banner.edit')->with([
            'banner' => $banner,
        ]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\banner  $banner
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        
        // Handle the user upload of avatar
        $request->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required',
        ]);

        $banner = Banner::find($id);


            $imageName = rand(1,50).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);

            $banner->update([
                'name' => $request->name,
                'description' => $request->description,
                'image' => 'images/'.$imageName,
            ]);
        
         return redirect(route('banner.index'))->with(['success' => 'Product Baru Ditambahkan']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\banner  $banner
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $banner = Banner::find($id);
        File::delete(storage_path('images/' . $banner->image));
        $banner->delete();
        return redirect(route('banner.index'))->with(['success' => 'Produk Sudah Dihapus']);
    }

}