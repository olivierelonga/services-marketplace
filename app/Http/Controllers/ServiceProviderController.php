<?php

namespace App\Http\Controllers;
use App\Models\Service;
use App\Models\User;
use Hash;

use Illuminate\Http\Request;

class ServiceProviderController extends Controller
{
    //
    public function showRegistrationForm()
    {
        return view('serviceProviders.register');
    }

    public function showForm()
    {
        $services = Service::all();
        return view('providers.register', compact('services'));
    }


    public function store(Request $request)
    {
        //exit("exit");
        $validated = $request->validate([
            'first_name'          => 'required|string|max:255',
            'last_name'           => 'required|string|max:255',
            'email'               => 'required|email|unique:users,email',
            'password'            => 'required|min:6|confirmed',
            'phone'               => 'required',
            'bio'                 => 'nullable|string',
            'years_of_experience' => 'nullable|integer|min:0|max:100',
            'location'            => 'nullable|string',
            'services'            => 'required|array',
            'date_of_birth'       => 'required|date|before:today',
            'gender'              => 'nullable|in:male,female,other',
            'hourly_rate'         => 'required',
        ]);

        $user = User::create([
            'first_name'          => $validated['first_name'],
            'last_name'           => $validated['last_name'],
            'email'               => $validated['email'],
            'password'            => Hash::make($validated['password']),
            'phone'               => $validated['phone'],
            'bio'                 => $validated['bio'],
            'years_of_experience' => $validated['years_of_experience'],
            'location'            => $validated['location'],
            'date_of_birth'       => $validated['date_of_birth'],
            'gender'              => $validated['gender'],
            'role'                => 'provider',
            'is_provider'         => '1',
            'hourly_rate'         => $validated['hourly_rate'],
        ]);

        $user->services()->attach($validated['services']);

        auth()->login($user);

        return redirect()->route('dashboard'); // or confirmation
    }
}
