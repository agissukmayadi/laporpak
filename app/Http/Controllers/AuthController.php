<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            if ($user->is_verified) {
                if (Auth::attempt($request->only('email', 'password'))) {
                    $request->session()->regenerate();
                    return redirect()->intended('/dashboard');
                }
            } else {

                if ($user->role == 'Goverment') {
                    return back()->withErrors([
                        'email' => 'Akun Instansi belum terverifikasi, Silahkan hubungi melalui kontak kami untuk proses verifikasi'
                    ]);
                }

                return back()->withErrors([
                    'email' => 'Your account is not verified.',
                ]);
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);

    }

    public function register()
    {
        return view('auth.register');
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'max:255', 'in:Goverment,Citizen'],
        ]);

        if ($request->role == 'Goverment') {
            $request->validate([
                'region' => ['required', 'string', 'max:255'],
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'region' => $request->role == 'Goverment' ? $request->region : null,
            'is_verified' => $request->role == 'Citizen' ? true : false,
        ]);

        return redirect()->route('login')->with('success', 'Register successfully.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Logout successfully.');
    }


}
