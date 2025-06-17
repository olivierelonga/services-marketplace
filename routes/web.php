<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceProviderController;

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
