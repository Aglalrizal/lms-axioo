<?php

namespace App\Livewire\Course;

use Livewire\Component;
use Livewire\Attributes\Rule;
use App\Models\CourseSyllabus;
use Illuminate\Support\Facades\Auth;
use App\Models\CourseContent as ModelsCourseContent;

class CourseContent extends Component
{
    public $syllabus_id;
    #[Rule('required')]
    public $title;
    #[Rule('required')]
    public $duration;
    public $video_url;
    #[Rule('required')]
    public $is_free_preview = false;
    #[Rule('required')]
    public $is_assessment = false;
    #[Rule('required')]
    public $content;

    public $courseContentId;
    public $courseContent;
    public function close(){

        $this->dispatch('close-add-content');
    }

    public function mount(){
        if($this->courseContentId)
        {
        $this->courseContent = ModelsCourseContent::where('id', $this->courseContentId)->first();
        $this->title = $this->courseContent->title;
        $this->duration = $this->courseContent->duration;
        $this->is_free_preview = $this->courseContent->is_free_preview;
        $this->is_assessment = $this->courseContent->is_assessment;
        $this->content = $this->courseContent->title;
        }
    }

    public function save(){
        $this->validate();
        $data = $this->validate();
        $data['course_syllabus_id'] = $this->syllabus_id;
        $lastOrder = ModelsCourseContent::where('course_syllabus_id', $this->syllabus_id)->max('order') ?? 0;
        $data['order'] = $lastOrder + 1;
        $data['created_by'] = Auth::user()->username;
        $data['modified_by'] = Auth::user()->username;
        ModelsCourseContent::create($data);
        $this->dispatch('close-add-content');
        flash()->success('Berhasil menambah konten!', [], 'Sukses');
        $this->reset();
    }
    public function render()
    {
        return view('livewire.course.course-content');
    }
}
