<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupportTicketController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\FaqController as UserFaq;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\SupportTicketController;
use App\Http\Controllers\BlogController;

Route::middleware(['auth', 'role:super-admin|admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/user/{role}', \App\Livewire\Admin\User\Index::class)->name('admin.user');
    Route::get('/admin/user/create/import', \App\Livewire\Admin\User\Import::class)->name('admin.user.import');
    Route::get('/admin/user/{username}/profile', \App\Livewire\Admin\User\ManageProfile::class)->name('admin.user.profile');
    Route::get('/admin/support-tickets', [SupportTicketController::class, 'index'])->name('admin.support-ticket.index');
    Route::get('/admin/support-tickets/{ticket}', [SupportTicketController::class, 'show'])->name('admin.support-ticket.show');
    Route::get('admin/report/activity-log', \App\Livewire\Admin\Reports\ActivityLog\Index::class)->name('admin.report.activity-log');
    Route::get('/admin/blogs', [BlogController::class, 'index_admin'])->name('admin.blog.index');
    Route::get('/admin/blogs/create', [BlogController::class, 'create'])->name('admin.blog.create');
});
Route::middleware(['auth', 'permission:manage faqs'])->group(function () {
    Route::get('admin/faqs', \App\Livewire\Admin\Faqs\Index::class)->name('admin.faqs');
});

Route::get('/help-center', [UserFaq::class, 'show_most_asked'])->name('public.help-center');
Route::get('/help-center/faqs', [UserFaq::class, 'show'])->name('public.help-center.faqs');
Route::get('/help-center/support', [SupportTicketController::class, 'create'])->name('public.help-center.support');
Route::get('/blogs', [BlogController::class, 'index_public'])->name('public.blog.index');
Route::get('/blogs/{blog}', [BlogController::class, 'show'])->name('public.blog.show');

Route::get('/', function () {
    return view('public.landing');
});

Route::get('/help-center/guide', function () {
    return view('public.help-center.guide');
})->name('public.help-center.guide');

Route::get('/help-center/guide/{slug}', function () {
    return view('public.help-center.guide-single');
})->name('public.help-center.guide-single');

// Route::get('/dashboard', function () {
//     return view('admin.dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

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
