<?php

namespace App\Http\Controllers\Seller;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Session;
use App\Models\Seller;
use App\Models\TanpaSopir;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class SellerOrderV1Controller extends Controller
{

    public function mtanpasopir()
    {
        $order = Order::with(['seller'])->where('fitur', 'v1')->where('seller_id', Auth::guard('seller')->id())->where('payment_status', 'paid')->orderBy('created_at', 'DESC')
        ->get();
        
        return view('seller.tanpasopirorder.table')->with([
            'order' => $order,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\contact  $contact
     * @return \Illuminate\Http\Response
     */

     public function show($id)
     {
        
        $order = Order::find($id);

        return view('seller.tanpasopirorder.show')->with([
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
        return view('seller.tanpasopirorder.edit')->with([
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
        $validator = Validator::make($request->all(), [
            'plat_nomer' => 'required',

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        //DATABASE TRANSACTION BERFUNGSI UNTUK MEMASTIKAN SEMUA PROSES SUKSES UNTUK KEMUDIAN DI COMMIT AGAR DATA BENAR BENAR DISIMPAN, JIKA TERJADI ERROR MAKA KITA ROLLBACK AGAR DATANYA SELARAS
        DB::beginTransaction();
        try {
            //CHECK DATA CUSTOMER BERDASARKAN EMAIL

            //SIMPAN DATA ORDER
            $Order = Order::find($id);

            $Order->update([
                'plat_nomer' => $request->plat_nomer,
            ]);


            // dd($order);
            $this->_OrderEmail($Order);
            // create coupon transaksi

            // delete cart
            if($Order){
                $product = TanpaSopir::where('id', $Order->product_id)->first();
                $product->stock = $product->stock - 1;
                $product->save();
            }

            // $this->_saveShiping($order);

            DB::commit();

            //REDIRECT KE HALAMAN FINISH TRANSAKSI
            Session::flash('success', 'Thank you. Your order has been received!');
            return redirect(route('mtanpasopir'))->with(['success' => 'Order Baru Ditambahkan']);

        } catch (\Exception $e) {
            //JIKA TERJADI ERROR, MAKA ROLLBACK DATANYA
            DB::rollback();
            dd($e);

            // DAN KEMBALI KE FORM TRANSAKSI SERTA MENAMPILKAN ERROR
            // return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
    /**
	 * Save order items
	 *
	 * @param Order $order order object
	 *
	 * @return void
	 */

     private function _OrderEmail($order)
     {

        $orderID = Order::where('id', $order->id)->orderBy('created_at', 'DESC')->firstOrFail();
        $seller = Seller::where('id', $orderID->seller_id)->first();
        $product = TanpaSopir::where('id', $orderID->product_id)->first();
       
        $data["seller_name"]= $seller->name;
        $data["seller_telpon"]= $seller->phone;
        $data["seller_email"]= $seller->email;
        $data["invoice"]= $orderID->invoice;
        $data["payment_status"]= $orderID->payment_status;
        $data["wilayah"]= $orderID->wilayah;
        $data["mulai"]= $orderID->mulai;
        $data["akhir"]= $orderID->akhir;
        $data["durasi"]= $orderID->durasi;
        $data["jam_mulai"]= $orderID->jam_mulai;
        $data["jam_akhir"]= $orderID->jam_akhir;
        $data["plat_nomer"]= $orderID->plat_nomer;
        $data["product_name"]= $product->productName->name;
        $data["product"]= $product->wilayah;
        $data["product_price"]= $product->price;
        $data["customer_name"]= $orderID->customer_name;
        $data["customer_telpon"]= $orderID->customer_telpon;
        $data["price"]= $orderID->price;
        $data["opration1"]= "carengibran@gmail.com";
        $data["opration2"]= "carengibran@gmail.com";

        $pdf = PDF::loadView('FrontEnd.user-invoice-v1', $data)
        ->setPaper('a4', 'portrait')->setWarnings(false)
        ->setOptions(['dpi' => 250, 'isHtml5ParserEnabled' => true, 'defaultFont' => 'sans-serif']);
        
        // return $pdf->stream(rand(1,50). '.' . 'pdf');

          // Send email with PDF attachment
        Mail::send('FrontEnd.user-email-v1', $data, function($message) use ($data, $pdf) {
            $message->to($data['seller_email'])
                ->subject($data['product_name'])
                ->attachData(
                    $pdf->output(),
                    'voucher.pdf',
                    [
                        'mime' => 'application/pdf',
                    ]
                )
                ->cc([
                    $data['opration1'],
                    $data['opration2']
                ]); // Dynamically add CC recipients
        });


     }

}