<?php

namespace App\Livewire\Admin\Course\Steps;

use App\Models\Course;
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

    #[On('delete-syllabus')]
    public function confirmDelete($id)
    {
        $this->syllabusToDelete = $id;

        sweetalert()
            ->showDenyButton()
            ->option('confirmButtonText', 'Yes, delete it!')
            ->option('denyButtonText', 'Cancel')
            ->option('id', $id) 
            ->warning('Are you sure you want to delete this syllabus?', ['Confirm Deletion']);
    }

    #[On('sweetalert:confirmed')]
    public function delete(array $payload)
    {
        if ($this->syllabusToDelete) {
            $syllabus = CourseSyllabus::find($this->syllabusToDelete);
            if ($syllabus) {
                $syllabus->delete();
                flash()->success('Syllabus deleted successfully!');
            } else {
                flash()->error('Syllabus not found.');
            }

            $this->syllabusToDelete = null;
            $this->refreshSyllabus();
            return;
        }
        // if ($this->faqToDelete) {
        //     $faq = Faq::find($this->faqToDelete);
        //     if ($faq) {
        //         $faq->delete();
        //         flash()->success('FAQ deleted successfully!');
        //     } else {
        //         flash()->error('FAQ not found.');
        //     }

        //     $this->faqToDelete = null;
        //     $this->refreshFaqs();
        //}
    }

    #[On('sweetalert:denied')]
    public function cancelDelete()
    {
        if($this->syllabusToDelete){
            $this->syllabusToDelete = null;
            // $this->dispatch('refresh-categories')->to(CreateFaqs::class);
            flash()->info('Syllabus deletion cancelled.');
        }
        // if($this->faqToDelete){
        //     $this->faqToDelete = null;
        //     flash()->info('Faq deletion cancelled.');
        // }
    }

    #[On('refresh-syllabus')]
    public function refreshSyllabus(){

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
