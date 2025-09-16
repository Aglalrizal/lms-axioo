<?php

namespace App\Livewire\Course\Public;

use App\Models\Course;
use App\Models\CourseProgress;
use App\Models\Enrollment;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.app')]
class Show extends Component
{
    public $course;

    public $slug;

    public $is_enrolled = false;

    public $url = '';

    public function enrollUser()
    {
        if (! Auth::check()) {
            session(['intended_course' => $this->course->id]);

            return redirect()->route('login');
        }

        // kalau course gratis → langsung enroll
        if ($this->course->access_type->value == 'free') {
            $transaction = Transaction::create([
                'course_id' => $this->course->id,
                'student_id' => Auth::id(),
                'status' => 'paid',
                'created_by' => Auth::user()->username,
            ]);

            Enrollment::create([
                'transaction_id' => $transaction->id,
                'student_id' => Auth::id(),
                'course_id' => $this->course->id,
                'enrolled_by' => Auth::user()->username,
                'enrolled_at' => now(),
                'created_by' => Auth::user()->username,
                'modified_by' => Auth::user()->username,
            ]);

            flash()->success('Pendaftaran berhasil!', [], 'Sukses');

            return $this->redirectToFirstContent();
        }

        $transaction = Transaction::create([
            'course_id' => $this->course->id,
            'student_id' => Auth::id(),
            'status' => 'pending',
            'created_by' => Auth::user()->username,
        ]);

        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $snapToken = \Midtrans\Snap::getSnapToken([
            'transaction_details' => [
                'order_id' => $transaction->id,
                'gross_amount' => $this->course->price,
            ],
            'customer_details' => [
                'email' => Auth::user()->email,
                'first_name' => Auth::user()->first_name,
            ],
        ]);

        $this->dispatch('midtrans-payment', token: $snapToken);
    }

    private function redirectToFirstContent()
    {
        $syllabus = $this->course->syllabus->sortBy('order')->first();
        $content = $syllabus?->courseContents->sortBy('order')->first();

        CourseProgress::updateOrCreate(
            [
                'student_id' => Auth::id(),
                'course_id' => $this->course->id,
                'course_content_id' => $content->id,
            ],
            [
                'is_completed' => false,
            ]
        );

        return redirect()->route('course.show.content', [
            'slug' => $this->slug,
            'syllabusId' => $syllabus->id,
            'courseContentId' => $content->id,
        ]);
    }

    #[On('refresh-course')]
    public function refresh()
    {
        $this->course = Course::where('slug', $this->slug)
            ->with(['teacher.courses', 'syllabus.courseContents'])
            ->firstOrFail();
        if (Auth::user()) {
            $this->is_enrolled = Enrollment::where('course_id', $this->course->id)
                ->where('student_id', Auth::user()->id)
                ->exists();
        }
    }

    public function mount($slug = null)
    {
        $this->slug = $slug;
        $this->course = Course::where('slug', $slug)
            ->with(['teacher.courses', 'syllabus.courseContents'])
            ->firstOrFail();

        if (Auth::check()) {

            $paidTransaction = Transaction::where('course_id', $this->course->id)->where('student_id', Auth::id())->where('status', 'paid')->first();

            $this->is_enrolled = Enrollment::where('course_id', $this->course->id)
                ->where('student_id', Auth::id())
                ->exists();

            if ($paidTransaction && ! $this->is_enrolled) {
                Enrollment::create([
                    'transaction_id' => $paidTransaction->id,
                    'student_id' => Auth::id(),
                    'course_id' => $this->course->id,
                    'enrolled_by' => Auth::user()->username,
                    'enrolled_at' => now(),
                    'created_by' => Auth::user()->username,
                    'modified_by' => Auth::user()->username,
                ]);

                flash()->success('Pendaftaran berhasil!', [], 'Sukses');

                return $this->redirectToFirstContent();
            }

            if ($this->is_enrolled) {
                $user = Auth::user();

                // Cari last completed berdasarkan global_order
                $lastCompleted = $this->course->contents()
                    ->whereHas('progresses', function ($q) use ($user) {
                        $q->where('student_id', $user->id)
                            ->where('is_completed', true);
                    })
                    ->orderBy('global_order', 'desc')
                    ->first();

                if ($lastCompleted) {
                    // Cari next content dari lastCompleted
                    $nextContent = $this->course->contents()
                        ->where('global_order', '>', $lastCompleted->global_order)
                        ->orderBy('global_order', 'asc')
                        ->first();

                    if ($nextContent && $nextContent->is_unlocked) {
                        $this->url = route('course.show.content', [
                            'slug' => $this->slug,
                            'syllabusId' => $nextContent->courseSyllabus->id,
                            'courseContentId' => $nextContent->id,
                        ]);
                    } else {
                        $this->url = route('course.show.content', [
                            'slug' => $this->slug,
                            'syllabusId' => $lastCompleted->courseSyllabus->id,
                            'courseContentId' => $lastCompleted->id,
                        ]);
                    }
                } else {
                    // Kalau belum ada yang completed → ambil content dengan global_order terkecil
                    $firstContent = $this->course->contents()
                        ->orderBy('global_order', 'asc')
                        ->first();

                    if ($firstContent) {
                        $this->url = route('course.show.content', [
                            'slug' => $this->slug,
                            'syllabusId' => $firstContent->courseSyllabus->id,
                            'courseContentId' => $firstContent->id,
                        ]);
                    } else {
                        $this->url = route('course.show', $this->slug);
                    }
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.course.public.show');
    }
}
