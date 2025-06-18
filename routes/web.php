<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceProviderController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

/*
Route::get('/', function () {
    return view('pages.home');
})->name('home');
the above can can shorten like this:
*/
Route::view('/', 'pages.home')->name('home');

// Route::get('/register/ServiceProvider', [ServiceProviderController::class, 'showRegistrationForm'])->name('provider.register');
// Route::post('/register/ServiceProvider', [ServiceProviderController::class, 'register']);

Route::get('/register/provider', [ServiceProviderController::class, 'showForm'])->name('provider.form');
Route::post('/register/provider', [ServiceProviderController::class, 'store'])->name('provider.store');


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/login');
})->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});