<?php

namespace App\Http\Controllers\Seller;
use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Support\Facades\Auth;
use App\Models\SellerPayment;


class SellerDashboardController extends Controller
{
    
    public function Dashboard()
    {   

        $seller = Seller::where('id', Auth::guard('seller')->id())->orderBy('created_at', 'DESC')->first();

        $payment = SellerPayment::orderBy('created_at', 'DESC')->where(['seller_id' => Auth::guard('seller')->id()])->get();

        $subtotal = collect($payment)->sum(function ($q) {
            return $q['price']; //SUBTOTAL TERDIRI DARI QTY * PRICE
        });

        return view('seller.dashboard.dashboard')->with([
            'seller' => $seller,
            'subtotal' => $subtotal,
            'payment' => $payment,
        ]);
    }

}