<?php

namespace App\Livewire\Admin\Course;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use App\Models\CourseCategory;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;

#[Layout('layouts.dashboard')]
class CreateCourse extends Component
{
    use WithFileUploads;

    #[Rule('required')]
    public $selectedCategory = '';
    #[Rule('required')]
    public $selectedInstructor = '';
    #[Rule('required')]
    public $title;
    #[Rule('required')]
    public $description;
    #[Rule('required')]
    public $courseLevel;
    public $categories;
    public $instructors;

    public $currentStep = 1;

    public $courseImage = '';

    public function next(){

    }
    #[On('go-to')]
    public function goTo($step){
        if($step == 1){
            $this->currentStep = $step;
            $this->dispatch('init-step-one-js');
            $this->dispatch('init-quill');
        }else if($step == 2){
            $this->currentStep = $step;
        }


    }

    public function stepOne(){
        $this->validate([
        'title' => 'required',
        'description' => 'required',
        'courseLevel' => 'required',
        'selectedInstructor' => 'required',
        'selectedCategory' => 'required'
        ]);
        $this->currentStep = 2;
    }

    public function render()
    {
        $this->categories = CourseCategory::all();
        $this->instructors = User::role('instructor')->get();
        return view('livewire.admin.course.create-course');
    }
}
