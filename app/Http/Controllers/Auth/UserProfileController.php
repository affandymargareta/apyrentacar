<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function UserAccount($id)
    {   
        $user = User::find($id);

        return view('FrontEnd.useraccount')->with([
            'user' => $user,
        ]);
    }
    /**
     * Update the user's profile information.
     */
    public function update(Request $request, $id)
    {

            $user = User::find($id);

            $user->update([
                'name' => $request->name,
                'gender' => $request->gender,
                'tanggal' => $request->tanggal,
                'bulan' => $request->bulan,
                'tahun' => $request->tahun,
                'city' => $request->city,
            ]);
        
            // dd($cart);


     return redirect()->back()->with(['Sukses' => 'Email Default']);

    }

}
