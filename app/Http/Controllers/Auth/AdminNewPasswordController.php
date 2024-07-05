<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules;
use App\Models\Admin;

class AdminNewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create($token, $email)
    {
        $admin = Admin::orderBy('created_at', 'DESC')->where(['remember_token' => $token])->where(['email' => $email])->first();
        if(!$admin) {
            return redirect()->route('admin.login')->with(['error' => 'Email Not Found']);
        }

        return view('auth.admin-reset-password')->with([
            'token' => $token,
            'email' => $email,
        ]);
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
        $admin = Admin::orderBy('created_at', 'DESC')->where(['email' => $request->email])->where(['remember_token' => $request->token])->first();
        $admin->remember_token = "";
        $admin->password = Hash::make($request->password);
        $admin->update();
        
        return redirect()->route('admin.login')->with(['error' => 'Email Not Found']);
    }
}
