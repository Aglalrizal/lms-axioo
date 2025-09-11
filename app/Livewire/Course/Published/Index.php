<?php

namespace App\Livewire\Course\Published;

use App\Models\User;
use App\Models\Course;
use App\Models\Program;
use Livewire\Component;
use App\Enums\AccessType;
use App\Enums\CourseLevel;
use Livewire\WithPagination;
use App\Models\CourseCategory;
use Livewire\Attributes\Layout;

#[Layout('layouts.dashboard')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterType = '';
    public $sortBy = 'title';
    public $sortDirection = 'asc';
    public $program, $accessType, $category, $level, $instructor;
    public function refresh() {}
    public function render()
    {
        $query = Course::query()->where('is_published', true);

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->program) {
            $query->whereHas('program', fn($q) => $q->where('slug', $this->program));
        }

        if ($this->accessType) {
            $query->where('access_type', $this->accessType);
        }

        if ($this->category) {
            $query->whereHas('courseCategory', fn($q) => $q->where('slug', $this->category));
        }

        if ($this->level) {
            $query->where('level', $this->level);
        }
        if ($this->instructor){
            $query->where('teacher_id', $this->instructor);
        }
        $courses = $query->with(['courseCategory', 'teacher', 'program'])
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);

        return view('livewire.course.published.index', [
            'programs' => Program::query()->select('id', 'name', 'slug')->get(),
            'categories' => CourseCategory::query()->select('id', 'name', 'slug')->get(),
            'instructors' => User::has('courses')->get(), 
            'accessTypes' => AccessType::toArray(),
            'courseLevels' => CourseLevel::toArray(),
            'courses' => $courses
        ]);
    }
}
