<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Seller;
use App\Models\User;
use App\Models\Province;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{

    public function Dashboard()
    {   
        
        $admin = Admin::where('id', Auth::guard('admin')->id())->orderBy('created_at', 'DESC')->first();

        $seller = DB::table('sellers')->count();
        $user = DB::table('users')->count();
        $order = DB::table('orders')->count();
        $ordersum =  DB::table('orders')->where('payment_status', 'paid')->sum('price');

        return view('admin.dashboard.dashboard')->with([
            'admin' => $admin,
            'seller' => $seller,
            'user' => $user,
            'order' => $order,
            'ordersum' => $ordersum,

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