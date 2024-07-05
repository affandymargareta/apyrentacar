<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Seller;

class SellerNewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create($token, $email)
    {
        
        $seller = Seller::orderBy('created_at', 'DESC')->where(['remember_token' => $token])->where(['email' => $email])->first();
        if(!$seller) {
            return redirect()->route('members.login')->with(['error' => 'Email Not Found']);
        }

        return view('auth.seller-reset-password', compact('token','email'));

    }
 
    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $seller = Seller::orderBy('created_at', 'DESC')->where(['email' => $request->email])->where(['remember_token' => $request->token])->first();
        $seller->remember_token = "";
        $seller->password = Hash::make($request->password);
        $seller->update();
        
        return redirect()->route('members.login')->with(['error' => 'Email Not Found']);
        
    }
}
