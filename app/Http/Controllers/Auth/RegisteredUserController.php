<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\CourseProgress;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users', 'alpha_dash'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.string' => 'Username harus berupa teks.',
            'username.min' => 'Username minimal :min karakter.',
            'username.max' => 'Username maksimal :max karakter.',
            'username.alpha_dash' => 'Username hanya boleh huruf, angka, tanda hubung, dan underscore.',
            'username.unique' => 'Username sudah digunakan.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',

            'password.required' => 'Password wajib diisi.',
            'password.string' => 'Password harus berupa teks.',
            'password.min' => 'Password minimal :min karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole('student');

        event(new Registered($user));

        Auth::login($user);

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

        return redirect(route('user.dashboard.profile', $user->username, absolute: false));
    }
}
