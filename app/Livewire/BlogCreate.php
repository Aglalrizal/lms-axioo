<?php

namespace App\Livewire;

use App\Livewire\Forms\BlogForm;
use Livewire\Component;
use App\Models\BlogCategory;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

class BlogCreate extends Component
{
    use WithFileUploads;

    public BlogForm $form;

    #[On('status')]
    public function changeStatus($status)
    {
        $this->form->status = $status;
    }

    public function save()
    {
        $this->form->store();

        $this->redirect('/admin/blogs');

        $this->form->reset();

        flash()->success('Blog berhasil dibuat.');
    }

    public function render()
    {
        return view(
            'livewire.blog-create',
            [
                'categories' => BlogCategory::get()
            ]
        );
    }
}
