<?php

namespace App\Livewire\Admin\Course;

use App\Models\CourseSyllabus;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class SyllabusModal extends Component
{
    #[Rule('required|min:5|string|max:50')]
    public $title = '';

    #[Rule('boolean')]
    public $is_completed = false;

    #[Rule('required|string|min:25|max:200')]
    public $description;

    public $formtitle = 'Buat Silabus';

    public $editform = false;

    public $courseId;

    public $syllabus;

    protected $messages = [
        'title.required' => 'Judul Silabus tidak boleh kosong',
        'title.min' => 'Judul Silabus minimal :min karakter',
        'title.max' => 'Judul Silabus maksimal :max karakter',
        'title.string' => 'Judul Silabus harus berupa teks',
        'description.required' => 'Deskripsi Silabus tidak boleh kosong',
        'description.min' => 'Deskripsi Silabus minimal :min karakter',
        'description.max' => 'Deskripsi Silabus maksimal :max karakter',
        'description.string' => 'Deskripsi Silabus harus berupa teks',
    ];

    public function render()
    {
        return view('livewire.admin.course.syllabus-modal');
    }

    public function save()
    {
        $this->title = trim($this->title);
        $this->validate();
        $data = $this->validate();
        $data['course_id'] = $this->courseId;
        $data['order'] = CourseSyllabus::max('order') + 1;
        $data['created_by'] = Auth::user()->username;
        $data['modified_by'] = Auth::user()->username;
        CourseSyllabus::create($data);
        $this->dispatch('refresh-syllabus');
        flash()->success('Berhasil menambah silabus!');
        $this->reset('title');
    }

    #[On('reset-syllabus-modal')]
    public function close()
    {
        $this->resetExcept('courseId');
        $this->formtitle = 'Buat Silabus';
        $this->resetValidation();
    }

    #[On('edit-syllabus-mode')]
    public function edit($id)
    {
        // dd($id);
        $this->editform = true;
        $this->formtitle = 'Edit Silabus';
        $this->syllabus = CourseSyllabus::findOrfail($id);
        $this->title = $this->syllabus->title;
        $this->description = $this->syllabus->description;
    }

    public function update()
    {
        $this->validate();
        $validated = $this->validate();
        $s = CourseSyllabus::findOrFail($this->syllabus->id);
        $s->update($validated);
        $this->dispatch('refresh-syllabus');
        flash()->success('Berhasil memperbarui silabus');
        $this->reset('title');
    }
}
