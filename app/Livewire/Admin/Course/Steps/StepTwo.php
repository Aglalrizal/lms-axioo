<?php

namespace App\Livewire\Admin\Course\Steps;

use App\Models\Course;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;
#[Layout('layouts.dashboard')]
class StepTwo extends Component
{

    use WithFileUploads;

    #[Rule('required|image|mimes:jpeg,png,jpg|max:2048')]
    public $courseImage;
    public $currentImage;
    public $slug;
    public $course;

    public $step = 2;

    #[On('refresh-image')]
    public function refreshImage(){

    }
    protected $messages = [
    'courseImage.required' => 'Gambar kursus wajib diunggah.',
    'courseImage.image'    => 'File yang diunggah harus berupa gambar.',
    'courseImage.mimes'    => 'Format gambar harus JPEG, PNG atau JPG.',
    'courseImage.max'      => 'Ukuran gambar tidak boleh lebih dari 2 MB.',
];

    public function saveImage(){
        $validated = $this->validate();
        $this->course = Course::where('slug', $this->slug)->firstOrFail();
        if ($this->courseImage) {
            if ($this->course->thumbnail && Storage::disk('public')->exists($this->course->thumbnail)) {
            Storage::disk('public')->delete($this->course->thumbnail);
            }
            $filename = 'course_' . now()->timestamp . '.' . $this->courseImage->getClientOriginalExtension();
            $path = $this->courseImage->storeAs('course-pictures', $filename, 'public');
            $validated['courseImage'] = $path;
        } else {
            unset($validated['courseImage']);
        }

        $this->course->update([
            'thumbnail' => $validated['courseImage'],
        ]);
        $this->reset(['courseImage', 'currentImage', 'course']);
        $this->currentImage = $validated['courseImage'];
        flash()->success('Berhasil menyimpan gambar!');
    }
    public function mount(): void{
        $this->course = Course::where('slug', $this->slug)->firstOrFail();
        $this->currentImage = $this->course->thumbnail;

    }
    public function render()
    {
        return view('livewire.admin.course.steps.step-two');
    }
}
