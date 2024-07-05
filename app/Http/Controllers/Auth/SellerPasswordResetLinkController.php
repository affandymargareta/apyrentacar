<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use App\Models\Seller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SellerPasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.seller-forgot-password');
    }
 
    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $seller = Seller::where('email', $request->email)->first();
        if(!$seller) {
            return redirect()->back()->with(['error' => 'Email Not Found']);
        }

        $token = Str::random(20);
        $seller->remember_token = $token;
        $seller->update();
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.

        $data["token"] = $token;
        $data["subject"] = "Reset Password";
        $data["email"] = $request->email;
        Mail::send('auth.seller-mail-password', $data, function($message)use($data) {
                $message->to($data["email"])->subject($data["subject"]);
        });

        return redirect()->route('members.login')->with(['error' => 'Email Not Found']);

    }

    
}
