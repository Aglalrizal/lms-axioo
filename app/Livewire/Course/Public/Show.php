<?php

namespace App\Livewire\Course\Public;

use App\Models\Course;
use Livewire\Component;
use App\Models\Enrollment;
use App\Models\Transaction;
use Livewire\Attributes\On;
use App\Models\CourseProgress;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class Show extends Component
{
    public $course;
    public $slug;

    public $is_enrolled = false;
    public $url = '';

    public function confirmEnrollUser()
    {
        sweetalert()
            ->showDenyButton()
            ->option('confirmButtonText', 'Iya, daftar!')
            ->option('denyButtonText', 'Batal')
            ->info('Apakah kamu yakin ingin mendaftar kursus ini?');
    }

    #[On('sweetalert:confirmed')]
    public function enrollUser()
    {
        if (!Auth::check()) {
            session(['intended_course' => $this->course->id]);
            return redirect()->route('login');
        }
        $transaction = Transaction::create([
            'course_id'  => $this->course->id,
            'student_id' => Auth::user()->id,
            'status'     => 'paid',
            'created_by' => Auth::user()->username,
        ]);
        Enrollment::create([
            'transaction_id' => $transaction->id,
            'student_id'     => Auth::user()->id,
            'course_id'      => $this->course->id,
            'enrolled_by'    => Auth::user()->username,
            'enrolled_at'    => now(),
            'created_by'     => Auth::user()->username,
            'modified_by'    => Auth::user()->username,
        ]);
        $this->dispatch('refresh-course');
        flash()->success('Pendaftaran berhasil!', [], 'Sukses');
        $syllabus = $this->course->syllabus->sortBy('order')->first();
        $content = $syllabus->courseContents->sortBy('order')->first();
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
        return redirect(route('course.show.content', [
            'slug' => $this->slug,
            'syllabusId' => $syllabus->id,
            'courseContentId' => $content->id
        ]));
    }

    #[On('sweetalert:denied')]
    public function cancelEnrollment()
    {
        flash()->info('Pendaftaran dibatalkan.', [], 'Informasi');
    }

    #[On('refresh-course')]
    public function refresh()
    {
        $this->course = Course::where('slug', $this->slug)
            ->with(['teacher.courses', 'syllabus.courseContents'])
            ->firstOrFail();
        if(Auth::user()){
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
            $this->is_enrolled = Enrollment::where('course_id', $this->course->id)
                ->where('student_id', Auth::id())
                ->exists();

            if ($this->is_enrolled) {
                $user = Auth::user();

                $lastCompleted = $this->course->contents()
                    ->whereHas('progresses', function ($q) use ($user) {
                        $q->where('student_id', $user->id)
                        ->where('is_completed', true);
                    })
                    ->orderBy('order', 'desc')
                    ->first();

                if ($lastCompleted) {
                    $nextContent = $this->course->contents()
                        ->where('order', '>', $lastCompleted->order)
                        ->orderBy('order')
                        ->first();

                    if ($nextContent && $nextContent->is_unlocked) {
                        $this->url = route('course.show.content', [
                            'slug' => $this->slug,
                            'syllabusId' => $nextContent->courseSyllabus->id,
                            'courseContentId' => $nextContent->id
                        ]);
                    } else {
                        $this->url = route('course.show.content', [
                            'slug' => $this->slug,
                            'syllabusId' => $lastCompleted->courseSyllabus->id,
                            'courseContentId' => $lastCompleted->id
                        ]);
                    }
                } else {
                    $firstSyllabus = $this->course->syllabus->sortBy('order')->first();
                    $firstContent  = $firstSyllabus?->courseContents->sortBy('order')->first();

                    if ($firstContent) {
                        $this->url = route('course.show.content', [
                            'slug' => $this->slug,
                            'syllabusId' => $firstSyllabus->id,
                            'courseContentId' => $firstContent->id
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
