<?php

namespace App\Livewire\Course\Published;

use App\Models\Course;
use Livewire\Component;
use App\Models\Enrollment;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('layouts.dashboard')]
class Show extends Component
{
    use WithPagination;
    public $course;
    public $slug;    
    public $search = '';
    public $activeTab = 'description';
    protected $updatesQueryString = ['activeTab', 'search'];
    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }
    public function updatingSearch(){
        $this->resetPage();
    }

    #[On('refresh-course')]
    public function refresh()
    {
        $this->course = Course::where('slug', $this->slug)
            ->with(['teacher', 'syllabus.courseContents'])
            ->firstOrFail();
    }

    public function mount($slug = null)
    {
        $this->slug = $slug;
        $this->course = Course::where('slug', $slug)
            ->with(['teacher', 'syllabus.courseContents'])
            ->firstOrFail();
    }

    public function render()
    {
        $enrolledStudents = Enrollment::with('student')
            ->where('course_id', $this->course->id)
            ->when($this->search, function ($query) {
                $query->whereHas('student', function ($q) {
                    $q->where('first_name', 'like', '%'.$this->search.'%')
                    ->orWhere('surname', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy('enrolled_at', 'desc')
            ->paginate(10);

        return view('livewire.course.published.show', [
            'enrolledStudents' => $enrolledStudents,
        ]);
    }
}
