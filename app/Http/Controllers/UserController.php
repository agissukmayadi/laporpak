<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('users.index', compact('users'));

    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
            'role' => ['required', 'string', 'in:Admin,Citizen,Goverment'],
        ]);

        if ($request->role == 'Goverment') {
            $request->validate([
                'region' => ['required', 'string', 'max:255'],
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'region' => $request->role == 'Goverment' ? $request->region : null,
            'is_verified' => true,
        ]);

        return redirect()->route('users')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'in:Admin,Citizen,Goverment'],
        ]);

        if ($request->role == 'Goverment') {
            $request->validate([
                'region' => ['required', 'string', 'max:255'],
            ]);
        }

        if ($request->password != null || $request->password_confirmation != null) {
            $request->validate([
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'password_confirmation' => ['required'],
            ]);
            $user->update([
                'password' => bcrypt($request->password),
            ]);
        }
        
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'role' => $request->role,
            'region' => $request->role == 'Goverment' ? $request->region : null,
        ]);

        return redirect()->route('users')->with('success', 'User updated successfully.');
    }

    public function verification(Request $request, User $user)
    {
        $user->is_verified = $request->is_verified;
        $user->save();

        return redirect()->route('users')->with('success', 'User verification updated successfully.');
    }
}
