<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
        ]);

        if ($request->old_password != null || $request->password != null || $request->password_confirmation != null) {
            $request->validate([
                'old_password' => ['required'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'password_confirmation' => ['required'],
            ]);


            if (!Hash::check($request->old_password, Auth::user()->password)) {
                return back()->withErrors([
                    'old_password' => 'Old password is incorrect.',
                ]);
            }

            Auth::user()->update([
                'password' => bcrypt($request->password),
            ]);
        }

        Auth::user()->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }

}