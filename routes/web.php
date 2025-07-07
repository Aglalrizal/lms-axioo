<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\FaqController as AdminFaq;
use App\Http\Controllers\FaqController as UserFaq;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\SocialiteController;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users/all', action: [UserController::class, 'index'])->name('admin.users.all');
    Route::post('/admin/users/{user}/role', [UserController::class, 'update'])->name('admin.users.updateRole');
    Route::get('/admin/faq', action: [AdminFaq::class, 'index'])->name('admin.faq');
    // Route::post('/admin/faq/store', action: [AdminFaq::class, 'store'])->name('admin.faq.store');
});

Route::middleware(['auth', 'permission:manage faqs'])->group(function () {
    Route::post('admin/faq/store', [AdminFaq::class, 'store'])->name('admin.faq.store');
    Route::put('admin/faq/{faq}', [AdminFaq::class, 'update'])->name('admin.faq.update');
    Route::delete('/faqs/{faq}', [AdminFaq::class, 'destroy'])->name('admin.faq.destroy');
    Route::post('/admin/faq/reorder', [AdminFaq::class, 'reorder'])->name('admin.faq.reorder');
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
