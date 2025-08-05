<?php

namespace App\Livewire;

use App\Models\Blog;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\BlogCategory;
use Livewire\WithFileUploads;
use App\Livewire\Forms\BlogForm;

class BlogEdit extends Component
{
    use WithFileUploads;

    public Blog $blog;
    public BlogForm $form;

    public function mount()
    {
        $this->form->setBlog($this->blog->load('author'));
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
