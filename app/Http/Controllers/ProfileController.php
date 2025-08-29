<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
            'phone'               => 'nullable|string',
            'bio'                 => 'nullable|string',
            'years_of_experience' => 'nullable|integer|min:0|max:100',
            'date_of_birth'       => 'nullable|date|before:today',
            'gender'              => 'nullable|in:male,female,other',
            'password'            => 'nullable|string|min:6|confirmed',
            'hourly_rate'         => 'nullable|numeric|min:0',
            'profile_picture'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'whatsapp_number'     => 'nullable|string',
            'same_whatsapp_number' => 'nullable|boolean',
        ]);

        // Handle WhatsApp Number
        $validated['whatsapp_number'] = $request->has('same_whatsapp_number') 
            ? $validated['phone'] 
            : $validated['whatsapp_number'];

        // Handle Profile Picture Upload
        if ($request->hasFile('profile_picture')) {
            // Delete old picture if it exists
            if ($user->profile_picture) {
                Storage::delete('public/profile_pictures/' . $user->profile_picture);
            }
            
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $validated['profile_picture'] = basename($path);
        }

        // Handle password update
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

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
