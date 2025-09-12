<?php

namespace App\Livewire\Admin\Course;

use App\Models\User;
use App\Models\Course;
use App\Models\Program;
use Livewire\Component;
use App\Enums\AccessType;
use App\Enums\CourseLevel;
use Livewire\Attributes\On;
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

    public $courseToDelete;
    public $program, $accessType, $category, $instructor, $level, $status;

    public function refresh() {}

    public function render()
    {
        $query = Course::query();

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->program === 'no-program') {
            $query->whereNull('program_id');
        } elseif ($this->program) {
            $query->whereHas('program', fn($q) => $q->where('slug', $this->program));
        }

        if ($this->category) {
            $query->whereHas('courseCategory', fn($q) => $q->where('slug', $this->category));
        }

        if ($this->instructor) {
            $query->where('teacher_id', $this->instructor);
        }
        
        if ($this->accessType) {
            $query->where('access_type', $this->accessType);
        }
        
        if ($this->level) {
            $query->where('level', $this->level);
        }

        if ($this->status){
            $query->where('is_published', $this->status);
        }

        $courses = $query->with(['courseCategory', 'teacher', 'program'])
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);

        return view('livewire.admin.course.index', [
            'programs' => Program::query()->select('id', 'name', 'slug')->get(),
            'categories' => CourseCategory::query()->select('id', 'name', 'slug')->get(),
            'instructors' => User::has('courses')->get(),
            'accessTypes' => AccessType::toArray(),
            'courseLevels' => CourseLevel::toArray(),
            'courses' => $courses
        ]);
    }
    #[On('delete-course')]
    public function confirmDelete($id)
    {
        $this->courseToDelete = $id;

        sweetalert()
            ->showDenyButton()
            ->option('confirmButtonText', 'Iya, hapus!')
            ->option('denyButtonText', 'Batal')
            ->option('id', $id)
            ->warning('Apakah anda yakin ingin menghapus kursus ini?', ['Confirm Deletion']);
    }

    #[On('sweetalert:confirmed')]
    public function delete(array $payload)
    {
        if ($this->courseToDelete) {
            $c = Course::findOrFail($this->courseToDelete);
            if ($c) {
                $c->delete();
                flash()->success('Kuis berhasil dihapus!');
            } else {
                flash()->error('Kuis tidak ditemukan.');
            }
            $this->courseToDelete = null;
            $this->refresh();
        }
    }

    #[On('sweetalert:denied')]
    public function cancelDelete()
    {
        if ($this->courseToDelete) {
            $this->courseToDelete = null;
            flash()->info('Penghapusan kuis dibatalkan.');
        }
    }
}
