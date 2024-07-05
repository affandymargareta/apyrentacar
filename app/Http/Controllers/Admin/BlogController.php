<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Image;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $blog = Blog::orderBy('created_at', 'DESC')
        ->get();

        return view('admin.blog.table', compact('blog'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // Handle the user upload of avatar
        $request->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required',
        ]);

        $imageName = rand(1,50).'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('images'), $imageName);

            $blog = Blog::create([
                'name' => $request->name,
                'description' => $request->description,
                'image' => 'images/'.$imageName,
            ]);
        
        return redirect(route('blog.index'))->with(['success' => 'Product Baru Ditambahkan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $blog = Blog::orderBy('created_at', 'DESC')->firstOrFail();
        $blog2 = Blog::orderBy('created_at', 'DESC')->get();

        return view('FrontEnd.blog-detail')->with([
            'blog' => $blog,
            'blog2' => $blog2,
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
        //
        $blog = Blog::find($id);

        return view('admin.blog.edit')->with([
            'blog' => $blog,
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
        //
    // Handle the user upload of avatar
    $request->validate([
        'name' => 'required',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'description' => 'required',
    ]);

    $blog = Blog::find($id);


        $imageName = rand(1,50).'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('images'), $imageName);

        $blog->update([
            'name' => $request->name,
            'description' => $request->description,
            'image' => 'images/'.$imageName,
        ]);
    
        return redirect(route('blog.index'))->with(['success' => 'Product Baru Ditambahkan']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $blog = Blog::find($id);
        File::delete(storage_path('images/' . $blog->image));
        $blog->delete();
        return redirect(route('blog.index'))->with(['success' => 'Produk Sudah Dihapus']);
    }
}
