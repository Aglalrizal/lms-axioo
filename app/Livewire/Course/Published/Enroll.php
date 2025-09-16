<?php

namespace App\Livewire\Course\Published;

use App\Models\Enrollment;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Enroll extends Component
{
    public $users;

    public $selectedUsers = [];

    public $courseId;

    private function loadEligibleUsers(): void
    {
        if (! $this->courseId) {
            $this->users = collect();

            return;
        }
        $alreadyEnrolled = Enrollment::where('course_id', $this->courseId)
            ->pluck('student_id')
            ->toArray();
        $this->users = User::role('student')
            ->whereNotIn('id', $alreadyEnrolled)
            ->get();
    }

    public function save()
    {
        // Only super-admin can enroll users via this component
        if (! Auth::user() || ! Auth::user()->hasRole('super-admin')) {
            abort(403);
        }
        if (empty($this->courseId)) {
            flash()->error('Course tidak valid. Silakan muat ulang halaman.');

            return;
        }
        $this->validate([
            'selectedUsers' => 'required|array|min:1',
            'selectedUsers.*' => 'integer|exists:users,id',
        ]);

        $enrolledCount = 0;
        $skippedCount = 0;
        foreach ($this->selectedUsers as $studentId) {
            // Skip if already enrolled in this course
            $already = Enrollment::where('course_id', $this->courseId)
                ->where('student_id', $studentId)
                ->exists();
            if ($already) {
                $skippedCount++;

                continue;
            }
            $transaction = Transaction::create([
                'course_id' => $this->courseId,
                'student_id' => $studentId,
                'status' => 'paid',
                'created_by' => Auth::user()->username,
            ]);
            Enrollment::create([
                'transaction_id' => $transaction->id,
                'student_id' => $studentId,
                'course_id' => $this->courseId,
                'enrolled_by' => Auth::user()->username,
                'enrolled_at' => now(),
                'created_by' => Auth::user()->username,
                'modified_by' => Auth::user()->username,
            ]);
            $enrolledCount++;
        }
        $this->reset('selectedUsers');
        $this->dispatch('refresh-course');
        $message = 'Berhasil mendaftarkan '.$enrolledCount.' peserta.';
        if ($skippedCount > 0) {
            $message .= ' '.$skippedCount.' sudah terdaftar dan dilewati.';
        }
        flash()->success($message, [], 'Sukses');
    }

    #[On('reset-enroll-modal')]
    public function close()
    {
        // Reset internal fields but keep courseId intact
        $this->reset('selectedUsers');
        // Only super-admin can view/update the enroll modal data
        if (! Auth::user() || ! Auth::user()->hasRole('super-admin')) {
            return;
        }
        $this->loadEligibleUsers();
    }

    public function mount()
    {
        // Prevent non super-admins from mounting the component
        if (! Auth::user() || ! Auth::user()->hasRole('super-admin')) {
            abort(403);
        }
        $this->loadEligibleUsers();
    }

    public function render()
    {
        return view('livewire.course.published.enroll');
    }
}
