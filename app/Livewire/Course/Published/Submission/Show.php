<?php

namespace App\Livewire\Course\Published\Submission;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('layouts.dashboard')]
class Show extends Component
{
    #[Url]
    public string $activeTab = 'instructions';

    public $course;

    public $assignment;

    public $submission;

    public $feedback;

    public $grade = '';

    public function mount($slug, $assignmentId, $submissionId)
    {
        $this->course = Course::where('slug', $slug)->first();
        $this->assignment = Assignment::with('courseContent')->where('id', $assignmentId)->firstOrFail();
        $this->submission = AssignmentSubmission::findOrFail($submissionId);
        $this->feedback = $this->submission->feedback ?? '';
        if ((int) $this->submission->grade <= 0) {
            $this->grade = 'reject';
        } else {
            $this->grade = 'accept';
        }
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function rules()
    {
        return [
            'feedback' => 'required|min:25|max:500|string',
            'grade' => 'required|in:accept,reject',
        ];
    }

    public function messages()
    {
        return [
            'feedback.required' => 'Feedback wajib diisi',
            'feedback.string' => 'Feedback haruslah berupa kalimat',
            'feedback.min' => 'Feedback minimal :min karakter',
            'feedback.max' => 'Feedback maksimal :max karakter',

            'grade.required' => 'Status wajib diisi',
            'grade.in' => 'Status hanya boleh lulus dan tidak lulus',
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        if ($validated['grade'] == 'accept') {
            $validated['grade'] = 1;
        } else {
            $validated['grade'] = 0;
        }

        $this->submission->update([
            'feedback' => $validated['feedback'],
            'grade' => $validated['grade'],
            'status' => 'graded',
            'graded_by' => Auth::id(),
            'graded_at' => now(),
        ]);

        if ($validated['grade'] === 1) {
            $this->submission->student
                ->progresses()
                ->updateOrCreate(
                    [
                        'student_id' => $this->submission->student_id,
                        'course_id' => $this->course->id,
                        'course_content_id' => $this->assignment->course_content_id,
                    ],
                    [
                        'is_completed' => true,
                    ]
                );
        }

        flash()->success('Penilaian berhasil disimpan', [], 'Sukses');
    }

    public function render()
    {
        return view('livewire.course.published.submission.show');
    }
}
