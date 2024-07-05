<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Order;

class AdminOrderController extends Controller
{

    public function index()
    {
        $order = Order::orderBy('created_at', 'DESC')->get();

        return view('admin.order.table')->with([
            'order' => $order,
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
        $order = Order::find($id);
        return view('admin.order.edit')->with([
            'order' => $order,
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
            'wilayah' => 'required',
            'jemput_id' => 'required',
            'invoice' => 'required',
            'order_date' => 'required',
            'payment_due' => 'required',
            'payment_status' => 'required',
            'payment_token' => 'required',
            'payment_url' => 'required',
            'user_id' => 'required',
            'lokasi_jemput' => 'required',
            'kembali_id' => 'required',
            'lokasi_kembali' => 'required',
            'mulai' => 'required',
            'durasi' => 'required',
            'jam_mulai' => 'required',
            'jam_akhir' => 'required',
            'seller_id' => 'required',
            'supir_telpon' => 'required',
            'supir_name' => 'required',
            'product_id' => 'required',
            'customer_name' => 'required',
            'customer_telpon' => 'required',
            'customer_email' => 'required',
            'price' => 'required',
        ]);

            $Order = Order::find($id);

            $Order->update([
                'wilayah' => $request->wilayah,
                'jemput_id' => $request->jemput_id,
                'invoice' => $request->invoice,
                'order_date' => $request->order_date,
                'payment_due' => $request->payment_due,
                'payment_status' => $request->payment_status,
                'payment_token' => $request->payment_token,
                'payment_url' => $request->payment_url,
                'user_id' => $request->user_id,
                'lokasi_jemput' => $request->lokasi_jemput,
                'mulai' => $request->mulai,
                'durasi' => $request->durasi,
                'jam_mulai' => $request->jam_mulai,
                'jam_akhir' => $request->jam_akhir,
                'seller_id' => $request->seller_id,
                'supir_telpon' => $request->supir_telpon,
                'supir_name' => $request->supir_name,
                'product_id' => $request->product_id,
                'customer_name' => $request->customer_name,
                'customer_telpon' => $request->customer_telpon,
                'customer_email' => $request->customer_email,
                'price' => $request->price,
            ]);
        
         return redirect(route('aorder.index'))->with(['success' => 'Order Baru Ditambahkan']);

    }

    public function destroy($id)
    {
        $order = Order::find($id);
        $order->delete();
        return redirect(route('aorder.index'))->with(['success' => 'Produk Sudah Dihapus']);
    }

}