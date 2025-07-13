<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\FaqController as UserFaq;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\SocialiteController;

Route::middleware(['auth', 'role:super-admin|admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/user/{role}', \App\Livewire\Admin\User\Index::class)->name('admin.user');
    Route::get('/admin/user/{username}/profile', \App\Livewire\Admin\User\ManageProfile::class)->name('admin.user.profile');
});

Route::middleware(['auth', 'permission:manage faqs'])->group(function () {
    Route::get('admin/faqs', \App\Livewire\Admin\Faqs\Index::class)->name('admin.faqs');
});

Route::get('/help-center', [UserFaq::class, 'show_most_asked'])->name('public.help-center');
Route::get('/help-center/faqs', [UserFaq::class, 'show'])->name('public.help-center.faqs');

Route::get('/', function () {
    return view('public.landing');
});

Route::get('/help-center/support', function () {
    return view('public.help-center.support');
})->name('public.help-center.support');

Route::get('/help-center/guide', function () {
    return view('public.help-center.guide');
})->name('public.help-center.guide');

Route::get('/help-center/guide/{slug}', function () {
    return view('public.help-center.guide-single');
})->name('public.help-center.guide-single');

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware('guest')->group(function () {
    Route::get('auth/{provider}', [SocialiteController::class, 'redirectToProvider'])->name('auth.redirect');
    Route::get('auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback'])->name('auth.callback');
});

require __DIR__ . '/auth.php';
