<?php

use App\Models\Course;
use App\Models\SupportTicket;
use App\Mail\SupportTicketReplyMail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\MidtransController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\FaqController as UserFaq;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;

Route::middleware(['auth'])->group(function () {
    Route::middleware(['role:super-admin|admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/user/{role}', \App\Livewire\Admin\User\Index::class)->name('admin.user');
        Route::get('/admin/user/create/import', \App\Livewire\Admin\User\Import::class)->name('admin.user.import');
        Route::get('/admin/user/{username}/profile', \App\Livewire\Admin\User\ManageProfile::class)->name('admin.user.profile');
        Route::get('/admin/course/', \App\Livewire\Admin\Course\Index::class)->name('admin.course.all');
        Route::get('/admin/course/published', \App\Livewire\Course\Published\Index::class)->name('admin.course.published');
        Route::get('/admin/course/published/{slug}', \App\Livewire\Course\Published\Show::class)->name('admin.course.published.show');
        Route::get('/admin/course/published/{slug}/quiz', \App\Livewire\Course\Published\QuizReport::class)->name('admin.course.published.quiz');
        Route::get('/admin/course/published/{slug}/enroll/import', \App\Livewire\Course\Published\Import::class)->name('admin.course.published.import');
        Route::get('/admin/course/create/{slug?}', \App\Livewire\Admin\Course\CreateCourse::class)->name('admin.course.create');
        Route::get('/admin/course/category', \App\Livewire\Admin\Course\CourseCategory::class)->name('admin.course.category');
        Route::get('/admin/course/program', \App\Livewire\Course\Program\Index::class)->name('admin.course.program');
        Route::get('admin/report/activity-log', \App\Livewire\Admin\Reports\ActivityLog\Index::class)->name('admin.report.activity-log');
        Route::get('admin/quiz', \App\Livewire\Quiz\Index::class)->name('quiz.index');

        Route::get('/admin/learning-path', \App\Livewire\LearningPathIndexAdmin::class)->name('admin.learning-paths.index');
        Route::get('/admin/learning-path/create', \App\Livewire\LearningPathCreate::class)->name('admin.learning-paths.create');
        Route::get('/admin/learning-path/{slug}/edit', \App\Livewire\LearningPathEdit::class)->name('admin.learning-paths.edit');

        Route::get('/admin/support-tickets', \App\Livewire\SupportTicketIndex::class)->name('admin.support-ticket.index');
        Route::get('/admin/support-tickets/{ticket}', \App\Livewire\SupportTicketShow::class)->name('admin.support-ticket.show');

        Route::get('/admin/inbox', \App\Livewire\ContactUsIndex::class)->name('admin.inbox.index');
        Route::get('/admin/inbox/{contactUs}', \App\Livewire\ContactUsShow::class)->name('admin.inbox.show');

        Route::get('/admin/cms/blogs', \App\Livewire\BlogIndexAdmin::class)->name('admin.cms.blog.index');
        Route::get('/admin/cms/blogs/create', \App\Livewire\BlogCreate::class)->name('admin.cms.blog.create');
        Route::get('/admin/cms/blogs/{blog}/edit', \App\Livewire\BlogEdit::class)->name('admin.cms.blog.edit');

        Route::get('/admin/cms/about-us', \App\Livewire\AboutUsCMS::class)->name('admin.cms.about-us');
        Route::get('/admin/cms/our-team', \App\Livewire\OurTeamCMS::class)->name('admin.cms.our-team');
    });
    Route::middleware('role:instructor')->group(function () {
        Route::get('/instructor/dashboard', \App\Livewire\Instructor\Dashboard::class)->name('instructor.dashboard');
        Route::get('/instructor/{username}/profile', \App\Livewire\ProfileCard::class)->name('instructor.profile');
        Route::get('/instructor/course', \App\Livewire\Instructor\Course\Index::class)->name('instructor.course');
        Route::get('/instructor/account', \App\Livewire\AccountCard::class)->name('instructor.account');
    });
    Route::middleware(['role:student'])->group(function () {
        Route::get('/student/dashboard', \App\Livewire\User\UserDashboard::class)->name('user.dashboard');
        Route::get('/student/dashboard/courses', \App\Livewire\User\UserCourses::class)->name('user.dashboard.courses');
        Route::get('/student/dashboard/certificates', \App\Livewire\User\UserCertificates::class)->name('user.dashboard.certificates');
        Route::get('/student/dashboard/{username}/profile', \App\Livewire\ProfileCard::class)->name('user.dashboard.profile');
        Route::get('/student/dashboard/account', \App\Livewire\AccountCard::class)->name('user.dashboard.account');
    });
    Route::middleware('permission:manage faqs')->group(function () {
        Route::get('/admin/cms/faqs', \App\Livewire\Admin\Faqs\Index::class)->name('admin.cms.faqs');
    });
    Route::get('/course/{slug}/{syllabusId}/{courseContentId}', \App\Livewire\Course\Public\ShowContent::class)->name('course.show.content');
    Route::get('/course/quiz/{attempt}', \App\Livewire\Quiz\Player::class)->name('quiz.player');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('guest')->group(function () {
    Route::get('auth/{provider}', [SocialiteController::class, 'redirectToProvider'])->name('auth.redirect');
    Route::get('auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback'])->name('auth.callback');
});

Route::get('/', \App\Livewire\Landing::class)->name('public.landing');

Route::get('/about-us', \App\Livewire\AboutUsPublic::class)->name('public.about-us');

Route::get('/learning-paths', \App\Livewire\LearningPathIndexPublic::class)->name('public.learning-paths.index');
Route::get('/learning-paths/{slug}', \App\Livewire\LearningPathShowPublic::class)->name('public.learning-paths.show');

Route::get('/course/explore', \App\Livewire\CourseExplore::class)->name('public.course.explore');
Route::get('/course/search', \App\Livewire\CourseSearch::class)->name('public.course.search');
Route::get('/course/{slug}', \App\Livewire\Course\Public\Show::class)->name('course.show');

Route::get('/blogs', \App\Livewire\BlogIndexPublic::class)->name('public.blog.index');
Route::get('/blogs/{blog}', [BlogController::class, 'show'])->name('public.blog.show');

Route::get('/help-center', [UserFaq::class, 'show_most_asked'])->name('public.help-center');
Route::get('/help-center/faqs', [UserFaq::class, 'show'])->name('public.help-center.faqs');
Route::get('/help-center/support', \App\Livewire\SupportTicketCreate::class)->name('public.help-center.support');

// 
// DEVELOPMENT AND TESTING 
//  

Route::get('/test', function () {
    return view('public.wrwrwrwr');
})->name('temp');

// Preview Email Route (hanya untuk development/testing)
Route::get('/preview-email/{ticketId}', function ($ticketId) {
    try {
        $ticket = SupportTicket::with('reply')->findOrFail($ticketId);

        if (!$ticket->reply) {
            return '<h1>No reply found for ticket #' . $ticketId . '</h1><p>Ticket ini belum memiliki reply dari admin.</p>';
        }

        return new SupportTicketReplyMail($ticket, $ticket->reply);
    } catch (Exception $e) {
        return '<h1>Error</h1><p>Error: ' . $e->getMessage() . '</p>';
    }
})->middleware('web');

require __DIR__ . '/auth.php';
