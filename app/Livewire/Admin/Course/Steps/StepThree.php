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

    public $isAddArticle = false;
    public $isAddQuiz = false;
    public $isAddVideo = false;
    public $isAddAssignment = false;
    public $syllabusId;
    public $courseContentId;
    public bool $hasAssignment = false;
    public $lastSyllabusId = 0;

    #[On('open-add-article')]
    public function openAddArticle($syllabusId, $courseContentId = null)
    {
        $this->isAddArticle = true;
        $this->isAddQuiz = false;
        $this->isAddVideo = false;
        $this->isAddAssignment = false;
        $this->syllabusId = $syllabusId;
        $this->courseContentId = $courseContentId;
    }

    #[On('open-add-quiz')]
    public function openAddQuiz($syllabusId, $courseContentId = null)
    {
        $this->isAddQuiz = true;
        $this->isAddArticle = false;
        $this->isAddVideo = false;
        $this->isAddAssignment = false;
        $this->syllabusId = $syllabusId;
        $this->courseContentId = $courseContentId;
        
    }
    #[On('open-add-video')]
    public function openAddVideo($syllabusId, $courseContentId = null)
    {
        $this->isAddVideo = true;
        $this->isAddQuiz = false;
        $this->isAddArticle = false;
        $this->isAddAssignment = false;
        $this->syllabusId = $syllabusId;
        $this->courseContentId = $courseContentId;
    }
    #[On('open-add-assignment')]
    public function openAddAssignment($syllabusId, $courseContentId = null)
    {
        $this->isAddVideo = false;
        $this->isAddQuiz = false;
        $this->isAddArticle = false;
        $this->isAddAssignment = true;
        $this->syllabusId = $syllabusId;
        $this->courseContentId = $courseContentId;
    }
    #[On('close-add-article')]
    public function closeCourseArticlePage(){
        $this->reset(['syllabusId', 'courseContentId']);
        $this->isAddArticle = false;
        $this->isAddQuiz = false;
        $this->isAddVideo = false;
        $this->isAddAssignment = false;
    }
    #[On('close-add-quiz')]
    public function closeCourseQuizPage(){
        $this->reset(['syllabusId', 'courseContentId']);
        $this->isAddQuiz = false;
        $this->isAddArticle = false;
        $this->isAddVideo = false;
        $this->isAddAssignment = false;
    }
    #[On('close-add-video')]
    public function closeCourseVideoPage(){
        $this->reset(['syllabusId', 'courseContentId']);
        $this->isAddQuiz = false;
        $this->isAddArticle = false;
        $this->isAddVideo = false;
        $this->isAddAssignment = false;
    }
    #[On('close-add-assignment')]
    public function closeCourseAssignmentPage(){
        $this->reset(['syllabusId', 'courseContentId']);
        $this->isAddQuiz = false;
        $this->isAddArticle = false;
        $this->isAddVideo = false;
        $this->isAddAssignment = false;
    }

    // #[On('done-loading-content')]
    // public function doneLoadingContent(){
    //     sleep(1);
    //     $this->isLoadingContent = false;
    //     $this->isAddArticle = false;
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
        'syllabus.courseContents' => fn($q) => $q->orderBy('order')
        ])->where('slug', $this->slug)->first();
        $this->hasAssignment = $this->course->hasAssignment();
        $this->lastSyllabusId = $this->course->syllabus()->latest('order')->first()->id;
    }
    public function mount(){
        $this->course = Course::with([
        'syllabus' => fn($q) => $q->orderBy('order'),
        'syllabus.courseContents' => fn($q) => $q->orderBy('order')
        ])->where('slug', $this->slug)->first();
        $this->hasAssignment = $this->course->hasAssignment();
        $this->lastSyllabusId = $this->course->syllabus()->latest('order')->first()->id;
    }
    public function render()
    {
        return view('livewire.admin.course.steps.step-three');
    }
}
