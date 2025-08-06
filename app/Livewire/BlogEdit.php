<?php

namespace App\Livewire;

use App\Models\Blog;
use Livewire\Component;
use App\Models\BlogCategory;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Livewire\Forms\BlogForm;

#[Layout('layouts.dashboard')]

class BlogEdit extends Component
{
    use WithFileUploads;

    public Blog $blog;
    public BlogForm $form;

    public function mount()
    {
        $this->form->setBlog($this->blog->load('author'));
    }

    public function updated($property)
    {
        if ($property === 'form.photo') {
            $this->form->photo_path = $this->form->photo ? $this->form->photo->temporaryUrl() : '';
        }
    }

    public function save()
    {
        $this->form->update();

        flash()->success('Blog berhasil di update.');
    }

    public function render()
    {
        return view('livewire.blog-edit', [
            'categories' => BlogCategory::get(),
            'oldPhotoUrl' => $this->form->photo_path,
        ]);
    }
}
