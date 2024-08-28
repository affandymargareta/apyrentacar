<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Seller;
use App\Models\User;
use App\Models\Province;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{

    public function Dashboard()
    {   
        
        $admin = Admin::orderBy('created_at', 'DESC')->first();

        $seller = DB::table('sellers')->count();
        $user = DB::table('users')->count();
        $ordercount = DB::table('orders')->where(['payment_status' => 'paid'])->count();
        $order = Order::orderBy('created_at', 'DESC')->where(['payment_status' => 'paid'])->get();
        $ordertotal = collect($order)->sum(function ($q) {
            return $q['price']; //SUBTOTAL TERDIRI DARI QTY * PRICE
        });


        return view('admin.dashboard.dashboard')->with([
            'admin' => $admin,
            'seller' => $seller,
            'user' => $user,
            'ordercount' => $ordercount,
            'ordertotal' => $ordertotal,
        ]);

    }
    public function Seller()
    {
        $seller = Seller::orderBy('created_at', 'DESC')
        ->get();
        $province = Province::orderBy('created_at', 'DESC')->get();

        return view('admin.dashboard.member')->with([
            'seller' => $seller,
            'province' => $province,
        ]);
    }

    public function User()
    {
        $user = User::orderBy('created_at', 'DESC')
        ->get();

        return view('admin.dashboard.user', compact('user'));
    }

    public function Selleredit($id)
    {
        $seller = Seller::find($id);

        return view('admin.dashboard.member-edit')->with([
            'seller' => $seller,
        ]);

    }

    public function Sellerupdate(Request $request, $id)
    {
        
            $seller = Seller::find($id);

            $seller->update([
                'suspend' => $request->suspend,
            ]);
        
            return redirect(route('member'))->with(['success' => 'Product Baru Ditambahkan']);

    }

}