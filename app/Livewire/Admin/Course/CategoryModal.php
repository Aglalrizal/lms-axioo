<?php

namespace App\Livewire\Admin\Course;

use App\Models\CourseCategory;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CategoryModal extends Component
{
    #[Rule('required')]
    public $name = '';

    public $formtitle = 'Buat Kategori';

    public $editform = false;

    public $courseCategory;

    public function render()
    {
        return view('livewire.admin.course.category-modal');
    }

    public function save()
    {
        $this->name = trim($this->name);
        $this->validate();
        $data = $this->validate();
        CourseCategory::create($data);
        $this->dispatch('refresh-categories');
        flash()->success('Berhasil menambah Course kategori!');
        $this->reset();
    }

    #[On('reset-course-category-modal')]
    public function close()
    {
        $this->reset();
    }

    #[On('edit-mode')]
    public function edit($id)
    {
        // dd($id);
        $this->editform = true;
        $this->formtitle = 'Edit Kategori';
        $this->courseCategory = CourseCategory::findOrfail($id);
        $this->name = $this->courseCategory->name;
    }

    public function update()
    {
        $this->validate();
        $validated = $this->validate();
        $cc = CourseCategory::findOrFail($this->courseCategory->id);
        $cc->update($validated);
        $this->dispatch('refresh-categories');
        flash()->success('Berhasil memperbarui Course Kategori!');
        $this->reset();
    }
}
