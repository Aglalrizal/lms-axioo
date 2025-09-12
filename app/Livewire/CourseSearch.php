<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Program;
use Livewire\Component;
use App\Enums\AccessType;
use App\Enums\CourseLevel;
use App\Models\CourseCategory;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('layouts.app')]

class CourseSearch extends Component
{
    use WithPagination;

    public $search, $program, $accessType, $category, $level;

    protected $queryString = [
        'search' => ['except' => ''],
        'program' => ['except' => ''],
        'accessType' => ['except' => ''],
        'category' => ['except' => ''],
        'level' => ['except' => ''],
    ];

    public function render()
    {
        $query = Course::query()->where('is_published', true);

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->program === 'no-program') {
            $query->whereNull('program_id');
        } elseif ($this->program) {
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

        $courses = $query
            ->select('id', 'title', 'thumbnail', 'level', 'access_type', 'program_id', 'course_category_id', 'short_desc', 'slug', 'duration')
            ->with([
                'program:id,name',
                'courseCategory:id,name'
            ])
            ->paginate(12);

        return view('livewire.course-search', [
            'programs' => Program::query()->select('id', 'name', 'slug')->get(),
            'categories' => CourseCategory::query()->select('id', 'name', 'slug')->get(),
            'accessTypes' => AccessType::toArray(),
            'courseLevels' => CourseLevel::toArray(),
            'courses' => $courses
        ]);
    }
}
