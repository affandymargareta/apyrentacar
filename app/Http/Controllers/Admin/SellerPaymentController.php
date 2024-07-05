<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\SellerPayment;
use App\Models\Seller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Image;

class SellerPaymentController extends Controller
{

    public function index()
    {
        $payment = SellerPayment::orderBy('created_at', 'DESC')->get();

        $seller = Seller::orderBy('created_at', 'DESC')->get();

        return view('admin.bill.table')->with([
            'payment' => $payment,
            'seller' => $seller,
        ]);
    }

    public function store(Request $request)
    {

        // Handle the user upload of avatar
        $request->validate([
            'name' => 'required',
            'seller_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date' => 'required',
            'price' => 'required',
        ]);

        $imageName = rand(1,50).'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('images'), $imageName);

        $payment = SellerPayment::create([
            'name' => $request->name,
            'seller_id' => $request->seller_id,
            'image' => 'images/'.$imageName,
            'price' => $request->price,
            'date' => $request->date,
        ]);
            // dd($product);

     return redirect(route('sellerpayment.index'))->with(['success' => 'Product Baru Ditambahkan']);
     
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $payment = SellerPayment::find($id);
        $seller = Seller::orderBy('created_at', 'DESC')->get();

        return view('admin.bill.edit')->with([
            'payment' => $payment,
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
            'name' => 'required',
            'seller_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date' => 'required',
            'price' => 'required',
        ]);

        $payment = SellerPayment::find($id);


            $imageName = rand(1,50).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);

            $payment->update([
                'name' => $request->name,
                'seller_id' => $request->seller_id,
                'image' => 'images/'.$imageName,
                'price' => $request->price,
                'date' => $request->date,
            ]);
        
         return redirect(route('sellerpayment.index'))->with(['success' => 'Product Baru Ditambahkan']);

    }

    public function destroy($id)
    {
        $payment = SellerPayment::find($id);
        File::delete(storage_path('images/' . $payment->image));
        $payment->delete();
        return redirect(route('sellerpayment.index'))->with(['success' => 'Produk Sudah Dihapus']);
    }

}