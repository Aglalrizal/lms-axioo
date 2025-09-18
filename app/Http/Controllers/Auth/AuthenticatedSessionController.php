<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\CourseProgress;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = $request->user();

        if (session()->has('intended_course')) {
            $courseId = session('intended_course');
            session()->forget('intended_course');

            $course = \App\Models\Course::with('syllabus.courseContents')->findOrFail($courseId);

            $alreadyEnrolled = \App\Models\Enrollment::where('course_id', $courseId)
                ->where('student_id', $user->id)
                ->exists();

            if (! $alreadyEnrolled) {

                if ($course->access_type->value == 'paid' || $course->access_type->value == 'free_trial') {
                    return redirect(route('course.show', $course->slug));
                }

                $transaction = \App\Models\Transaction::create([
                    'course_id' => $courseId,
                    'student_id' => $user->id,
                    'status' => 'paid',
                    'created_by' => $user->username,
                ]);

                \App\Models\Enrollment::create([
                    'transaction_id' => $transaction->id,
                    'student_id' => $user->id,
                    'course_id' => $courseId,
                    'enrolled_by' => $user->username,
                    'enrolled_at' => now(),
                    'created_by' => $user->username,
                    'modified_by' => $user->username,
                ]);

                $syllabus = $course->syllabus->sortBy('order')->first();
                $content = $syllabus->courseContents->sortBy('order')->first();

                CourseProgress::updateOrCreate(
                    [
                        'student_id' => $user->id,
                        'course_id' => $course->id,
                        'course_content_id' => $content->id,
                    ],
                    [
                        'is_completed' => false,
                    ]
                );

                $redirectUrl = route('course.show.content', [
                    'slug' => $course->slug,
                    'syllabusId' => $syllabus->id,
                    'courseContentId' => $content->id,
                ]);
            } else {
                $lastProgress = CourseProgress::where('student_id', $user->id)
                    ->where('course_id', $course->id)
                    ->latest('updated_at')
                    ->first();

                if ($lastProgress) {
                    $totalContents = $course->syllabus->flatMap->courseContents->count();
                    $completedContents = $course->progresses()
                        ->where('student_id', Auth::id())
                        ->where('is_completed', true)
                        ->count();

                    if ($totalContents === $completedContents) {
                        $redirectUrl = route('course.show', $course->slug);
                    } else {
                        $content = $lastProgress->courseContent;
                        $redirectUrl = route('course.show.content', [
                            'slug' => $course->slug,
                            'syllabusId' => $content->syllabus_id,
                            'courseContentId' => $content->id,
                        ]);
                    }
                } else {
                    $syllabus = $course->syllabus->sortBy('order')->first();
                    $content = $syllabus->courseContents->sortBy('order')->first();

                    $redirectUrl = route('course.show.content', [
                        'slug' => $course->slug,
                        'syllabusId' => $syllabus->id,
                        'courseContentId' => $content->id,
                    ]);
                }
            }

            return redirect()->to($redirectUrl);
        }

        if ($user->hasRole(['super-admin', 'admin'])) {
            return redirect()->intended('/admin/dashboard');
        } elseif ($user->hasRole('instructor')) {
            return redirect()->intended('/instructor/dashboard');
        }

        return redirect()->intended('/student/dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
