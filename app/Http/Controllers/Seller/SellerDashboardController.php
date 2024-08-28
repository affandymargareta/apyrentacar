<?php

namespace App\Http\Controllers\Seller;
use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Support\Facades\Auth;
use App\Models\SellerPayment;
use App\Models\Order;


class SellerDashboardController extends Controller
{
    
    public function Dashboard()
    {   

        $seller = Seller::where('id', Auth::guard('seller')->id())->orderBy('created_at', 'DESC')->first();

        $payment = SellerPayment::orderBy('created_at', 'DESC')->where(['seller_id' => Auth::guard('seller')->id()])->get();

        $paymenttotal = collect($payment)->sum(function ($q) {
            return $q['price']; //SUBTOTAL TERDIRI DARI QTY * PRICE
        });
        $order = Order::orderBy('created_at', 'DESC')->where(['payment_status' => 'paid'])->where(['seller_id' => Auth::guard('seller')->id()])->get();
        $ordertotal = collect($order)->sum(function ($q) {
            return $q['price']; //SUBTOTAL TERDIRI DARI QTY * PRICE
        });

        $subtotal =  $ordertotal - $paymenttotal;

        return view('seller.dashboard.dashboard')->with([
            'seller' => $seller,
            'subtotal' => $subtotal,
            'payment' => $payment,
        ]);
    }

}