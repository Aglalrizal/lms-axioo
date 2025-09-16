<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class SocialiteController extends Controller
{
    public function redirectToProvider($provider)
    {
        if (! in_array($provider, ['google'])) {
            return redirect(route('login'))->withErrors(['provider' => 'Invalid Provider']);
        }

        try {
            return Socialite::driver($provider)->redirect();
        } catch (Throwable $e) {
            return redirect(route('login'))->withErrors(['provider' => 'Something went wrong']);
        }
    }

    public function handleProviderCallback($provider)
    {
        if (! in_array($provider, ['google'])) {
            return redirect(route('login'))->withErrors(['provider' => 'Invalid Provider']);
        }

        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (Throwable $e) {
            return redirect('/')->with('error', 'Gagal masuk dengan google.');
        }

        // Cari user berdasarkan email
        $user = User::where('email', $googleUser->email)->first();

        if (! $user) {
            // Buat user baru kalau belum ada
            $user = User::create([
                'username' => Str::slug($googleUser->name, '').now()->timestamp,
                'first_name' => strstr($googleUser->name, ' ', true) ?: $googleUser->name, // fallback
                'surname' => ltrim(strstr($googleUser->name, ' ')) ?: '', // fallback
                'email' => $googleUser->email,
                'email_verified_at' => now(),
                'provider_id' => $googleUser->id,
                'provider_name' => 'google',
                'provider_token' => $googleUser->token ?? null,
                'provider_refresh_token' => $googleUser->refreshToken ?? null,
            ]);

            // Assign role default (misalnya student)
            $user->assignRole('student');
            Auth::login($user, true);

            return redirect(route('user.dashboard.profile', $user->username));
        }

        Auth::login($user, true);

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
                    $content = $lastProgress->courseContent;
                    $redirectUrl = route('course.show.content', [
                        'slug' => $course->slug,
                        'syllabusId' => $content->syllabus_id,
                        'courseContentId' => $content->id,
                    ]);
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

        // Redirect sesuai role
        if ($user->hasRole(['super-admin', 'admin'])) {
            return redirect()->intended('/admin/dashboard');
        } elseif ($user->hasRole('instructor')) {
            return redirect()->intended('/instructor/dashboard');
        }

        return redirect()->intended('/student/dashboard');
    }
}
