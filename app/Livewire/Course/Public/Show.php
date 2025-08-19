<?php

namespace App\Livewire\Course\Public;

use App\Models\Course;
use Livewire\Component;
use App\Models\Enrollment;
use App\Models\Transaction;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.dashboard')]
class Show extends Component
{
    public $course;
    public $slug;

    public $is_enrolled;

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
            ->with(['teacher', 'syllabus.courseContents'])
            ->firstOrFail();
        $this->is_enrolled = Enrollment::where('course_id', $this->course->id)
            ->where('student_id', Auth::user()->id)
            ->exists();
    }
    public function mount($slug = null)
    {
        $this->slug = $slug;
        $this->course = Course::where('slug', $slug)
            ->with(['teacher', 'syllabus.courseContents'])
            ->firstOrFail();
        $this->is_enrolled = Enrollment::where('course_id', $this->course->id)
            ->where('student_id', Auth::user()->id)
            ->exists();
    }
    public function render()
    {
        return view('livewire.course.public.show');
    }
}
