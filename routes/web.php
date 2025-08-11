<?php

use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use App\Http\Controllers\ServiceProviderController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Api\ServiceSearchController;
use App\Http\Controllers\TestimonialController;


Route::view('/', 'pages.home')->name('home');

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
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
});


# password reset routes
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::middleware(['auth'])->post('/fake-pay', function () {
    $user = Auth::user();
    $user->is_premium = true;
    $user->premium_expires_at = now()->addMonths(1); // or addMonths(3)
    $user->save();

    return redirect()->back()->with('success', 'Premium activated for 1 month!');
})->name('fake.pay');



// Show the reply form
Route::get('/messages/{id}/reply', [MessageController::class, 'reply'])->name('messages.reply');

// Handle the reply submission
Route::post('/messages/{id}/reply', [MessageController::class, 'sendReply'])->name('messages.sendReply');

Route::get('/service-suggestions', [ServiceSearchController::class, 'suggest']);
// Route::get('/services/providers', [ServiceProviderController::class, 'showProviders']);


Route::get('/search', [ServiceSearchController::class, 'index'])->name('search');

Route::get('/profile/{user}', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.view');


// Testimonial routes
Route::middleware(['auth'])->group(function () {
    Route::post('/users/{user}/testimonials', [TestimonialController::class, 'store'])->name('testimonials.store');
    Route::put('/users/{user}/testimonials/{testimonial}', [TestimonialController::class, 'update'])->name('testimonials.update');
    Route::delete('/users/{user}/testimonials/{testimonial}', [TestimonialController::class, 'destroy'])->name('testimonials.destroy');
});



// Contact routes - Add these to your existing routes/web.php file
Route::middleware(['auth'])->group(function () {
    // Store contact request
    Route::post('/users/{user}/contact', [MessageController::class, 'store'])->name('contacts.store');
    
    // Contact inbox for users
    Route::get('/contacts/inbox', [MessageController::class, 'inbox'])->name('contacts.inbox');
    
    // Mark contact as responded
    Route::patch('/contacts/{contact}/respond', [MessageController::class, 'markAsResponded'])->name('contacts.respond');
    
    // Archive contact
    Route::patch('/contacts/{contact}/archive', [MessageController::class, 'archive'])->name('contacts.archive');
});