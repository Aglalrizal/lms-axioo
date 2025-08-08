<?php

namespace App\Livewire\Admin\Course\Steps;

use App\Models\Course;
use App\Models\CourseContent;
use App\Models\CourseSyllabus;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;

#[Layout('layouts.dashboard')]
class StepThree extends Component
{
    public $slug;
    public $course;
    public $step = 3;
    public $syllabusToDelete;
    public $courseContentToDelete;

    public $isAddContent = false;
    public $isAddQuiz = false;
    public $syllabusId;
    public $courseContentId;

    #[On('open-add-content')]
    public function openAddContent($syllabusId, $courseContentId = null)
    {
        $this->isAddContent = true;
        $this->isAddQuiz = false;
        $this->syllabusId = $syllabusId;
        $this->courseContentId = $courseContentId;
    }

    #[On('open-add-quiz')]
    public function openAddQuiz($syllabusId, $courseContentId = null)
    {
        $this->isAddQuiz = true;
        $this->isAddContent = false;
        $this->syllabusId = $syllabusId;
        $this->courseContentId = $courseContentId;
    }
    #[On('close-add-content')]
    public function closeCourseContentPage(){
        $this->reset(['syllabusId', 'courseContentId']);
        $this->isAddContent = false;
        $this->isAddQuiz = false;
    }
    #[On('close-add-quiz')]
    public function closeCourseQuizPage(){
        $this->reset(['syllabusId', 'courseContentId']);
        $this->isAddQuiz = false;
        $this->isAddContent = false;
    }

    // #[On('done-loading-content')]
    // public function doneLoadingContent(){
    //     sleep(1);
    //     $this->isLoadingContent = false;
    //     $this->isAddContent = false;
    // }

    #[On('delete-syllabus')]
    public function confirmDeleteSyllabus($id)
    {
        $this->syllabusToDelete = $id;

        sweetalert()
            ->showDenyButton()
            ->option('confirmButtonText', 'Iya, hapus!')
            ->option('denyButtonText', 'Batal')
            ->option('id', $id) 
            ->warning('Apakah kamu yakin ingin menghapus silabus ini?', ['Confirm Deletion']);
    }
    #[On('delete-course-content')]
    public function confirmDeleteCourseContent($id)
    {
        $this->courseContentToDelete = $id;

        sweetalert()
            ->showDenyButton()
            ->option('confirmButtonText', 'Iya, hapus!')
            ->option('denyButtonText', 'Batal')
            ->option('id', $id) 
            ->warning('Apakah kamu yakin ingin menghapus konten ini?', ['Confirm Deletion']);
    }
    
    #[On('sweetalert:confirmed')]
    public function delete(array $payload)
    {
        if ($this->syllabusToDelete) {
            $syllabus = CourseSyllabus::find($this->syllabusToDelete);
            if ($syllabus) {
                $syllabus->delete();
                flash()->success('Silabus berhasil dihapus!', [], 'Sukses');
            } else {
                flash()->error('Silabus tidak ditemukan.');
            }

            $this->syllabusToDelete = null;
            $this->refreshSyllabus();
            return;
        }
        if ($this->courseContentToDelete) {
            $courseContent = CourseContent::find($this->courseContentToDelete);
            
            if ($courseContent) {
                $courseContent->delete();
                flash()->success('Konten berhasil dihapus.', [], 'Sukses');
            } else {
                flash()->error('Konten tidak ditemukan.');
            }

            $this->courseContentToDelete = null;
            $this->refreshSyllabus();
        }
    }

    #[On('sweetalert:denied')]
    public function cancelDelete()
    {
        if($this->syllabusToDelete){
            $this->syllabusToDelete = null;
            // $this->dispatch('refresh-categories')->to(CreateFaqs::class);
            flash()->info('Membatalkan penghapusan silabus.', [], 'Informasi');
        }
        if($this->courseContentToDelete){
            $this->courseContentToDelete = null;
            flash()->info('Membatalkan penghapusan konten.', [], 'Informasi');
        }
    }

    #[On('refresh-syllabus')]
    public function refreshSyllabus(){
        $this->course = Course::with([
        'syllabus' => fn($q) => $q->orderBy('order'),
        'syllabus.contents' => fn($q) => $q->orderBy('order')
        ])->where('slug', $this->slug)->first();
    }
    public function mount(){
        $this->course = Course::with([
        'syllabus' => fn($q) => $q->orderBy('order'),
        'syllabus.contents' => fn($q) => $q->orderBy('order')
        ])->where('slug', $this->slug)->first();
    }
    public function render()
    {
        return view('livewire.admin.course.steps.step-three');
    }
}
