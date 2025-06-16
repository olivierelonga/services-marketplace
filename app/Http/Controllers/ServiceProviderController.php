<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceProviderController extends Controller
{
    //
    public function showRegistrationForm()
    {
        return view('serviceProviders.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'phone'    => 'required',
            'bio'      => 'nullable|string',
            'services' => 'required|array'
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'phone'    => $request->phone,
            'bio'      => $request->bio,
            'role'     => 'provider',
        ]);

        // Attach services later when services table is ready
        // $user->services()->attach($request->services);

        auth()->login($user);

        return redirect()->route('dashboard'); // or wherever
    }
}
