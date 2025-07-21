<?php

namespace App\Livewire\Admin\Course;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use App\Models\CourseSyllabus;

class SyllabusModal extends Component
{
    #[Rule('required')]
    public $title = '';
    #[Rule('boolean')]
    public $is_completed = false;
    public $formtitle = 'Buat Course Syllabus';
    public $editform=false;
    public $courseId;
    public $syllabus;
    public function render()
    {
        return view('livewire.admin.course.syllabus-modal');
    }

    public function save(){
        $this->title = trim($this->title);
        $this->validate();
        $data = $this->validate();
        $data['course_id'] = $this->courseId;  
        $data['order'] = CourseSyllabus::max('order') + 1;
        $data['created_by'] = auth()->user()->username;
        $data['modified_by'] = auth()->user()->username;
        CourseSyllabus::create($data);
        $this->dispatch('refresh-syllabus');
        flash()->success('Berhasil menambah Course Syllabus!');
        $this->reset('title');
    }

    #[On('reset-syllabus-modal')]
    public function close(){
        $this->reset('title');
    }
    #[On('edit-syllabus-mode')]
    public function edit($id){
        //dd($id);
        $this->editform=true;
        $this->formtitle='Edit FAQ Kategori';
        $this->syllabus=CourseSyllabus::findOrfail($id);
        $this->title=$this->syllabus->title;
    }
    public function update(){
        $this->validate();
        $validated=$this->validate();
        $s=CourseSyllabus::findOrFail($this->syllabus->id);
        $s->update($validated);
        $this->dispatch('refresh-syllabus');
        flash()->success('Berhasil memperbarui Course Syllabus');
        $this->reset('title');
    }
}
