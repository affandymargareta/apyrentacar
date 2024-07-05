<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\File;

class PaymentController extends Controller
{

    public function index()
    {
        $payment = Payment::with('province')->orderBy('created_at', 'DESC')->get();

        return view('admin.payment.table')->with([
            'payment' => $payment,
        ]);
    }


    public function store(Request $request)
    {

        // Handle the user upload of avatar
        $request->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'jenis' => 'required',
            'status' => 'required',
            'wilayah' => 'required',
            'bagasi' => 'required',
            'kursi' => 'required',
            'stock' => 'required',
            'price' => 'required',
        ]);



            $payment = Payment::create([
                'name' => $request->name,
                'jenis' => $request->jenis,
                'wilayah' => $request->wilayah,
                'bagasi' => $request->bagasi,
                'kursi' => $request->kursi,
                'stock' => $request->stock,
                'price' => $request->price,
                'image' => 'images/'.$imageName,
                'status' => '1',
            ]);
            // dd($payment);

     return redirect(route('payment.index'))->with(['success' => 'payment Baru Ditambahkan']);
     
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payment = Payment::find($id);

        return view('admin.payment.edit')->with([
            'payment' => $payment,
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'jenis' => 'required',
            'status' => 'required',
            'wilayah' => 'required',
            'bagasi' => 'required',
            'kursi' => 'required',
            'stock' => 'required',
            'price' => 'required',
        ]);

        $payment = Payment::find($id);

            $payment->update([
                'name' => $request->name,
                'jenis' => $request->jenis,
                'wilayah' => $request->wilayah,
                'bagasi' => $request->bagasi,
                'kursi' => $request->kursi,
                'stock' => $request->stock,
                'price' => $request->price,
                'image' => 'images/'.$imageName,
                'status' => '1',
            ]);
        
         return redirect(route('payment.index'))->with(['success' => 'payment Baru Ditambahkan']);

    }

    public function destroy($id)
    {
        $payment = Payment::find($id);
        $payment->delete();
        return redirect(route('payment.index'))->with(['success' => 'Produk Sudah Dihapus']);
    }

}