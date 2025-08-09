<?php

namespace App\Livewire;

use App\Models\Blog;
use Livewire\Component;
use Livewire\Attributes\On;
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

    public function publish()
    {
        $this->form->publish();
    }

    public function unpublish()
    {
        $this->blog->update(['status' => 'drafted']);

        flash()->success('Blog telah dimasukkan ke draft.');
    }

    public function confirmation()
    {
        sweetalert()
            ->showDenyButton()
            ->option('confirmButtonText', 'Ya, Hapus Blog!')
            ->option('denyButtonText', 'Batal')
            ->warning('Apakah Anda yakin ingin menghapus blog ini?');
    }

    #[On('sweetalert:confirmed')]
    public function delete()
    {
        $this->blog->delete();

        flash()->success('Blog berhasil dihapus.');

        return redirect()->route('dashboard.cms.blogs.index');
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
        ]);
    }
}
