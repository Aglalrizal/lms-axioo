<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\SocialiteController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/help-center', function () {
    return view('help-center');
});

Route::get('/help-center/faq', function () {
    return view('help-center-faq');
});

Route::get('/help-center/support', function () {
    return view('help-center-support');
});

Route::get('/help-center/guide', function () {
    return view('help-center-guide');
});

Route::get('/help-center/guide/{slug}', function () {
    return view('help-center-guide-single');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard/admin-student', function () {
    return view('admin-student');
})->middleware(['auth', 'verified'])->name('admin-student');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware('guest')->group(function (){
    Route::get('auth/{provider}', [SocialiteController::class, 'redirectToProvider'])->name('auth.redirect');
    Route::get('auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback'])->name('auth.callback');
});

require __DIR__ . '/auth.php';
