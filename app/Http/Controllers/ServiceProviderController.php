<?php

namespace App\Http\Controllers;
use App\Models\Service;
use App\Models\User;
use App\Models\WorkTask;
use Hash;

use Illuminate\Http\Request;

class ServiceProviderController extends Controller
{
    //

    public function index()
    {
        $workTasks = WorkTask::where('assigned_to', auth()->id())->latest()->get();
        return view('dashboard.provider_dashboard', compact('workTasks'));
    }

    public function showRegistrationForm()
    {
        return view('serviceProviders.register');
    }

    public function showForm()
    {
        $services = Service::all();
        return view('providers.register', compact('services'));
    }

    public function userShowForm()
    {
        $services = Service::all();
        return view('user.register', compact('services'));
    }


    public function store(Request $request)
    {
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
            //'city'                => 'required|string|max:255',
            //'province'            => 'required|string|max:255',
            //'postal_code'         => 'required|string|max:20',
            'profile_picture'     => 'nullable|image|mimes:jpg,jpeg,png|max:10240'
        ]);

        $whatsappNumb = $request->input('whatsapp_number');
        if ($request->same_whatsapp_number) {
            $whatsappNumb = $validated['phone'];
        } 

        $has_whatsapp = false;
        if ($request->same_whatsapp_number == 'on' || !empty($request->input('whatsapp_number'))) {
            $has_whatsapp = true;
        } 


        // Handle Profile Picture Upload
        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $profilePicturePath = basename($path); // keep full path for retrieval
        }


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
            //'city'                => $validated['city'],
            //'province'            => $validated['province'],
            //'postal_code'         => $validated['postal_code'],
            'whatsapp_number'     => $whatsappNumb,
            'has_whatsapp'        => $has_whatsapp,
            'profile_picture'     => $profilePicturePath,
        ]);

        $user->services()->attach($validated['services']);

        auth()->login($user);

        return redirect()->route('dashboard'); // or confirmation
    }

    public function storeNormalUser(Request $request)
    {
        $validated = $request->validate([
            'first_name'          => 'required|string|max:255',
            'last_name'           => 'required|string|max:255',
            'email'               => 'required|email|unique:users,email',
            'password'            => 'required|min:6|confirmed',
            'phone'               => 'required',
            'location'            => 'nullable|string',
            'date_of_birth'       => 'required|date|before:today',
            'gender'              => 'nullable|in:male,female,other',
        ]);

        $whatsappNumb = $request->input('whatsapp_number');
        if ($request->same_whatsapp_number) {
            $whatsappNumb = $validated['phone'];
        } 

        $has_whatsapp = false;
        if ($request->same_whatsapp_number == 'on' || !empty($request->input('whatsapp_number'))) {
            $has_whatsapp = true;
        } 


        $user = User::create([
            'first_name'          => $validated['first_name'],
            'last_name'           => $validated['last_name'],
            'email'               => $validated['email'],
            'password'            => Hash::make($validated['password']),
            'phone'               => $validated['phone'],
            'location'            => $validated['location'],
            'date_of_birth'       => $validated['date_of_birth'],
            'gender'              => $validated['gender'],
            'role'                => 'user',
            'is_provider'         => '0',
            'whatsapp_number'     => $whatsappNumb,
            'has_whatsapp'        => $has_whatsapp,
        ]);

        //$user->services()->attach($validated['services']);

        auth()->login($user);

        return redirect()->route('dashboard'); // or confirmation
    }

    /**
     * Resize image using GD
     */
    private function resizeImage($src, $dst, $width, $height)
    {
        $imagick = new \Imagick($src);
        $imagick->resizeImage($width, $height, \Imagick::FILTER_LANCZOS, 1, true);
        $imagick->setImageFormat('jpeg');
        $imagick->writeImage($dst);
        $imagick->destroy();
    }
}