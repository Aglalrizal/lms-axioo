<?php

namespace App\Livewire\Admin\Course;

use App\Models\Course;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;

#[Layout('layouts.dashboard')]
class Index extends Component
{
    public $search = '';
    public $filterType = '';
    public $sortBy = 'title';
    public $sortDirection = 'asc';

    public $courseToDelete;

    public function refresh(){
        
    }

    public function render()
    {
        $courses = Course::with(['courseCategory','teacher', 'syllabus.courseContents'])
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterType, function ($query) {
                $query->where('course_type', $this->filterType); 
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(5);

        return view('livewire.admin.course.index', [
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
        if($this->courseToDelete){
            $this->courseToDelete = null;
            flash()->info('Penghapusan kuis dibatalkan.');
        }
    }

}
