<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function index()
     {
         $customer = Customer::orderBy('created_at', 'DESC')
         ->get();
 
         return view('admin.customer.table', compact('customer'));
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
             'instagram' => 'required',
             'facebook' => 'required',
             'customer_name' => 'required',
             'customer_telpon' => 'required',
             'customer_email' => 'required',
         ]);
 
             $customer = Customer::create([
                 'instagram' => $request->instagram,
                 'facebook' => $request->facebook,
                 'customer_name' => $request->customer_name,
                 'customer_telpon' => $request->customer_telpon,
                 'customer_email' => $request->customer_email,
             ]);
         
      return redirect(route('acustomer.index'))->with(['success' => 'Product Baru Ditambahkan']);
      
      }
 
     /**
      * Display the specified resource.
      *
      * @param  \App\Models\contact  $contact
      * @return \Illuminate\Http\Response
      */
 
     public function show($id)
     {
         //
     }
 
     /**
      * Show the form for editing the specified resource.
      *
      * @param  \App\Models\contact  $contact
      * @return \Illuminate\Http\Response
      */
 
     public function edit($id)
     {
         $customer = Customer::find($id);
 
         return view('admin.customer.edit')->with([
             'customer' => $customer,
         ]);
     }
     
     /**
      * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  \App\Models\contact  $contact
      * @return \Illuminate\Http\Response
      */
 
     public function update(Request $request, $id)
     {
         
         // Handle the user upload of avatar
         $request->validate([
            'instagram' => 'required',
            'facebook' => 'required',
         ]);
 
         $customer = Customer::find($id);
 
             $customer->update([
                'instagram' => $request->instagram,
                'facebook' => $request->facebook,
             ]);
         
          return redirect(route('acustomer.index'))->with(['success' => 'Product Baru Ditambahkan']);
 
     }
 
     /**
      * Remove the specified resource from storage.
      *
      * @param  \App\Models\contact  $contact
      * @return \Illuminate\Http\Response
      */
 
     public function destroy($id)
     {
         $customer = Customer::find($id);
         $customer->delete();
         return redirect(route('acustomer.index'))->with(['success' => 'Produk Sudah Dihapus']);
     }
}
