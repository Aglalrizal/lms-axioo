<?php

namespace App\Livewire\Admin\Course;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.dashboard')]
class CourseCategory extends Component
{
    use WithPagination;
    public $search = '';

    public $categoryToDelete;

        #[On('delete-category')]
    public function confirmDelete($id)
    {
        $this->categoryToDelete = $id;

        sweetalert()
            ->showDenyButton()
            ->option('confirmButtonText', 'Yes, delete it!')
            ->option('denyButtonText', 'Cancel')
            ->option('id', $id)
            ->warning('Are you sure you want to delete this course category?', ['Confirm Deletion']);
    }

    #[On('sweetalert:confirmed')]
    public function delete(array $payload)
    {
        $courseCategory = \App\Models\CourseCategory::find($this->categoryToDelete);
        if ($courseCategory) {
            $courseCategory->delete();
            flash()->success('Course category deleted successfully!');
        } else {
            flash()->error('Course category not found.');
        }

        $this->categoryToDelete = null;
        $this->refreshCourseCategories();
    }

    #[On('sweetalert:denied')]
    public function cancelDelete()
    {
        $this->categoryToDelete = null;
        flash()->info('Course category deletion cancelled.');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        $courseCategories= \App\Models\CourseCategory::with('courses')
        ->where(function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        return view('livewire.admin.course.course-category', compact('courseCategories'));
    }
    #[On('refresh-categories')]
    public function refreshCourseCategories(){
        $this->resetPage();
    }
}
