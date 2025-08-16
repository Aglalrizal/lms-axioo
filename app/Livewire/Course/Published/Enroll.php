<?php

namespace App\Livewire\Course\Published;

use App\Models\User;
use Livewire\Component;
use App\Models\Enrollment;
use App\Models\Transaction;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class Enroll extends Component
{
    public $users;
    public $selectedUsers = [];
    public $courseId;
    public function save(){
        foreach ($this->selectedUsers as $studentId) {
            $transaction = Transaction::create([
                'course_id'  => $this->courseId,
                'student_id' => $studentId,
                'status'     => 'paid',
                'created_by' => Auth::user()->username,
            ]);
            Enrollment::create([
                'transaction_id' => $transaction->id,
                'student_id'     => $studentId,
                'course_id'      => $this->courseId,
                'enrolled_by'    => Auth::user()->username,
                'enrolled_at'    => now(),
                'created_by'     => Auth::user()->username,
                'modified_by'    => Auth::user()->username,
            ]);
        }
        $this->selectedUsers = [];
        $this->dispatch('refresh-course');
        flash()->success('Berhasil mendaftarkan peserta', [], 'Sukses');
    }
    #[On('reset-enroll-modal')]
    public function close(){
        $this->reset();
        $alreadyEnrolled = Enrollment::where('course_id', $this->courseId)
        ->pluck('student_id')
        ->toArray();
        $this->users = User::role('student')
        ->whereNotIn('id', $alreadyEnrolled)
        ->get();
    }
    public function mount(){
        $alreadyEnrolled = Enrollment::where('course_id', $this->courseId)
        ->pluck('student_id')
        ->toArray();
        $this->users = User::role('student')
        ->whereNotIn('id', $alreadyEnrolled)
        ->get();
    }
    public function render()
    {
        return view('livewire.course.published.enroll');
    }
}
