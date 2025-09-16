<?php

namespace App\Livewire;

use App\Livewire\Forms\BlogForm;
use App\Models\BlogCategory;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.dashboard')]

class BlogCreate extends Component
{
    use WithFileUploads;

    public BlogForm $form;

    public function updated($property)
    {
        if ($property === 'form.photo') {
            $this->form->photo_path = $this->form->photo ? $this->form->photo->temporaryUrl() : '';
        }
    }

    #[On('status')]
    public function changeStatus($status)
    {
        $this->form->status = $status;
    }

    public function save()
    {
        $this->form->store();

        $this->redirect(route('admin.cms.blog.index'));

        $this->form->reset();

        flash()->success('Blog berhasil dibuat.');
    }

    public function render()
    {
        return view(
            'livewire.blog-create',
            [
                'categories' => BlogCategory::get(),
            ]
        );
    }
}
