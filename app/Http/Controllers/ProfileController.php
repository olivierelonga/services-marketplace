<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'first_name'          => 'required|string|max:255',
            'last_name'           => 'required|string|max:255',
            'email'               => 'required|email|unique:users,email,' . $user->id,
            'location'            => 'nullable|string',
            'bio'                 => 'nullable|string',
            'years_of_experience' => 'nullable|integer|min:0|max:100',
            'date_of_birth'       => 'required|date|before:today',
            'gender'              => 'nullable|in:male,female,other',
            'password'            => 'nullable|string|min:6|confirmed',
        ]);

        $user->update([
            'first_name'          => $validated['first_name'],
            'last_name'           => $validated['last_name'],
            'email'               => $validated['email'],
            'location'            => $validated['location'],
            'bio'                 => $validated['bio'],
            'years_of_experience' => $validated['years_of_experience'],
            'date_of_birth'       => $validated['date_of_birth'],
            'gender'              => $validated['gender'],
            'password'            => $validated['password']
                ? Hash::make($validated['password']) : $user->password,
        ]);

        return redirect()->route('dashboard')->with('success', 'Profile updated successfully.');
    }

    public function show(User $user)
    {
        // Make sure only providers can be viewed
        if (! $user->is_provider) {
            abort(404);
        }

        return view('profile.show', compact('user'));
    }
}
