<?php

namespace App\Livewire\Course\Published;

use App\Models\User;
use App\Models\Course;
use Livewire\Component;
use App\Models\Enrollment;
use App\Models\Transaction;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
#[Layout('layouts.dashboard')]
class Import extends Component
{
    use WithFileUploads;
    public $courseId;
    public $slug;
    #[Rule('required|file|mimes:csv,xlsx|max:2048')]
    public $file;
    public $previewUsers = [];
    public $not_found = [];
    public function import(){
        $validUsers = collect($this->previewUsers)
        ->filter(fn ($user) => $user['status'] === 'ok');
        foreach ($validUsers as $userData) {

            $user = User::where('username', $userData['username'])
                ->whereHas('roles', fn($q) => $q->where('name', 'student'))
                ->first();

            if (! $user) continue;
            $transaction = Transaction::create([
                'course_id'  => $this->courseId,
                'student_id' => $user->id,
                'status'     => 'paid',
                'created_by' => Auth::user()->username,
            ]);

            Enrollment::create([
                'transaction_id' => $transaction->id,
                'student_id'     => $user->id,
                'course_id'      => $this->courseId,
                'enrolled_by'    => Auth::user()->username,
                'enrolled_at'    => now(),
                'created_by'     => Auth::user()->username,
                'modified_by'    => Auth::user()->username,
            ]);
        }
        flash()->success('Enrollment selesai!');
        $this->reset(['file', 'previewUsers', 'not_found']);
        $this->dispatch('refresh-course');
        return redirect()->route('admin.course.published.show', $this->slug);
    }
    // #[On('download-template')]
    public function downloadTemplate(){
        $filename ='templateEnrollment.xlsx';
        $path = storage_path('app/public/'.$filename);
        return response()->download($path, $filename);
    }
    public function previewEnrollUser()
    {
        $this->validate();
        $this->reset(['previewUsers', 'not_found']);
        $collection = Excel::toCollection(null, $this->file)[0];;
        $usernameCounts = [];
        foreach ($collection as $row) {
            $username = strtolower(trim($row[0]));
                if ($username === '') continue;
                if($username === 'username') continue;
            $usernameCounts[$username] = ($usernameCounts[$username] ?? 0) + 1;
        }
        $this->previewUsers = $collection
            ->filter(fn ($row) => strtolower(trim($row[0])) !== '' && strtolower(trim($row[0])) !== 'username')
            ->map(function ($row) use ($usernameCounts) {
                $username = strtolower(trim($row[0]));
                $userModel = User::where('username', $username)
                    ->whereHas('roles', fn($q) => $q->where('name', 'student'))
                    ->first();

                $status = 'ok';

                if (! $userModel) {
                    $status = 'not_found';
                } elseif (($usernameCounts[$username] ?? 0) > 1) {
                    $status = 'duplicate';
                } elseif (Enrollment::where('course_id', $this->courseId)
                    ->where('student_id', $userModel->id)
                    ->exists()) {
                    $status = 'already_enrolled';
                }

                return [
                    'username' => $username,
                    'status'   => $status,
                ];
            })
            ->values()
            ->toArray();
    }

    public function mount($slug = null){
        $this->slug = $slug;
        $this->courseId = Course::where('slug', $slug)->first()->id;
    }

    public function render()
    {
        return view('livewire.course.published.import');
    }
}
