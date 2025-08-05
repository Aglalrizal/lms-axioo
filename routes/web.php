<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\FaqController as UserFaq;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\BlogController;

Route::middleware(['auth'])->group(function () {
    Route::middleware(['role:super-admin|admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/user/{role}', \App\Livewire\Admin\User\Index::class)->name('admin.user');
        Route::get('/admin/user/create/import', \App\Livewire\Admin\User\Import::class)->name('admin.user.import');
        Route::get('/admin/user/{username}/profile', \App\Livewire\Admin\User\ManageProfile::class)->name('admin.user.profile');
        Route::get('/admin/course/', \App\Livewire\Admin\Course\Index::class)->name('admin.course.all');
        Route::get('/admin/course/create/{slug?}', \App\Livewire\Admin\Course\CreateCourse::class)->name('admin.course.create');
        Route::get('/admin/course/category', \App\Livewire\Admin\Course\CourseCategory::class)->name('admin.course.category');
        Route::get('/admin/cms/support-tickets', \App\Livewire\SupportTicketIndex::class)->name('admin.cms.support-ticket.index');
        Route::get('/admin/cms/support-tickets/{ticket}', \App\Livewire\SupportTicketShow::class)->name('admin.cms.support-ticket.show');
        Route::get('admin/report/activity-log', \App\Livewire\Admin\Reports\ActivityLog\Index::class)->name('admin.report.activity-log');
        Route::get('admin/quiz', \App\Livewire\Quiz\Index::class)->name('quiz.index');
        Route::get('/admin/blogs', [BlogController::class, 'index_admin'])->name('admin.blog.index');
        Route::get('/admin/blogs/create', [BlogController::class, 'create'])->name('admin.blog.create');
        Route::get('/admin/blogs/{blog}/edit', [BlogController::class, 'edit'])->name('admin.blog.edit');
        Route::get('admin/quiz', \App\Livewire\Quiz\Index::class)->name('quiz.index');
    });
    Route::middleware('role:instructor')->group(function () {
        Route::get('/instructor/dashboard', \App\Livewire\Instructor\Dashboard::class)->name('instructor.dashboard');
        Route::get('/instructor/{username}/profile', \App\Livewire\ProfileCard::class)->name('instructor.profile');
        Route::get('/instructor/course', \App\Livewire\Instructor\Course\Index::class)->name('instructor.course');
    });
    Route::middleware(['role:student'])->group(function () {
        Route::get('/dashboard', \App\Livewire\User\UserDashboard::class)->name('user.dashboard.index');
        Route::get('/dashboard/courses', \App\Livewire\User\UserCourses::class)->name('user.dashboard.courses');
        Route::get('/dashboard/certificates', \App\Livewire\User\UserCertificates::class)->name('user.dashboard.certificates');
        Route::get('/dashboard/profile', \App\Livewire\User\UserProfile::class)->name('user.dashboard.profile');
        Route::get('/dashboard/account', \App\Livewire\User\UserAccount::class)->name('user.dashboard.account');
    });
});

Route::middleware(['auth', 'permission:manage faqs'])->group(function () {
    Route::get('admin/cms/faqs', \App\Livewire\Admin\Faqs\Index::class)->name('admin.cms.faqs');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/help-center', [UserFaq::class, 'show_most_asked'])->name('public.help-center');
Route::get('/help-center/faqs', [UserFaq::class, 'show'])->name('public.help-center.faqs');
Route::get('/help-center/support', \App\Livewire\SupportTicketCreate::class)->name('public.help-center.support');

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



Route::middleware('guest')->group(function () {
    Route::get('auth/{provider}', [SocialiteController::class, 'redirectToProvider'])->name('auth.redirect');
    Route::get('auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback'])->name('auth.callback');
});

require __DIR__ . '/auth.php';
