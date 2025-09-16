<?php

namespace App\Livewire\Course\Published\Submission;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Course;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.dashboard')]
class Index extends Component
{
    use WithPagination;

    public $search = '';

    public $course;

    public $assignment;

    public $activeTab = 'students';

    public function mount($slug, $assignmentId)
    {
        $this->course = Course::where('slug', $slug)->firstOrFail();
        $this->assignment = Assignment::with('courseContent')->findOrFail($assignmentId);
    }

    public function render()
    {
        $query = AssignmentSubmission::with('student')
            ->where('assignment_id', $this->assignment->id);
        if ($this->search) {
            $query->whereHas('student', function ($q) {
                $q->whereRaw("CONCAT(first_name, ' ', surname) LIKE ?", ["%{$this->search}%"])
                    ->orWhere('first_name', 'like', '%'.$this->search.'%')
                    ->orWhere('surname', 'like', '%'.$this->search.'%')
                    ->orWhere('username', 'like', '%'.$this->search.'%');
            });
        }

        return view('livewire.course.published.submission.index', [
            'submissions' => $query->latest()->paginate(10),
        ]);
    }
}
