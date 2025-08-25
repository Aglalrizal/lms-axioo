<?php

namespace App\Livewire\Course\Program;

use App\Models\Program;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Create extends Component
{
    use WithFileUploads;
    #[Rule('required|string')]
    public $name = '';
    #[Rule('required|image|mimes:jpeg,png,jpg|max:2048')]
    public $programImage;
    public $currentImage;
    public $formtitle = 'Buat Program';
    public $editform=false;
    public $program;

    protected $messages = [
        'name.required'         => 'Nama program wajib diisi',
        'name.string'           => 'Nama program hanya boleh string',
        
        'programImage.required' => 'Gambar wajib diunggah.',
        'programImage.image'    => 'File yang diunggah harus berupa gambar.',
        'programImage.mimes'    => 'Format gambar harus JPEG, PNG atau JPG.',
        'programImage.max'      => 'Ukuran gambar tidak boleh lebih dari 2 MB.',
    ];

    public function save(){
        $this->name = trim($this->name);
        $this->validate();
        $path = null;
        if ($this->programImage) {
            $path = $this->programImage->store('programs', 'public');
        }
        Program::create([
            'name' => $this->name,
            'image_path' => $path,
        ]);
        $this->dispatch('refresh-program');
        flash()->success('Berhasil menambah Program!');
        $this->reset();
    }
    #[On('reset-program-modal')]
    public function close(){
        $this->reset();
        $this->resetValidation();
    }
    #[On('edit-mode')]
    public function edit($id){
        //dd($id);
        $this->editform=true;
        $this->formtitle='Edit Program';
        $this->program=Program::findOrfail($id);
        $this->name=$this->program->name;
        $this->currentImage = $this->program->image_path;
    }
    public function update(){
        $this->validate();
        $p=Program::findOrFail($this->program->id);
        if ($this->programImage) {
            if ($p->image_path && Storage::disk('public')->exists($p->image_path)) {
                Storage::disk('public')->delete($p->image_path);
            }
            $path = $this->programImage->store('programs', 'public');
        } else {
            $path = $p->image_path;
        }

        $p->update([
            'name' => $this->name,
            'image_path' => $path,
        ]);
        $this->dispatch('refresh-program');
        flash()->success('Berhasil memperbarui Program!');
        $this->reset();
    }
    public function render()
    {
        return view('livewire.course.program.create');
    }
}
