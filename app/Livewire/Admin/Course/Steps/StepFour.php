<?php

namespace App\Livewire\Admin\Course\Steps;

use App\Models\Course;
use App\Traits\HandlesBase64Images;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Mews\Purifier\Facades\Purifier;

#[Layout('layouts.dashboard')]
class StepFour extends Component
{
    use HandlesBase64Images;

    public $step = 4;

    public $slug;

    public $extra_description = '';

    public $is_published = false;

    public $course;

    public function rules()
    {
        return [
            'extra_description' => 'required|string',

            // function ($attribute, $value, $fail) {
            //     $plainText = trim(strip_tags($value));
            //     if (strlen($plainText) < 20) {
            //         $fail('Deskripsi ekstra kursus minimal 20 karakter.');
            //     }
            //     if (strlen($plainText) > 1000) {
            //         $fail('Deskripsi ekstra kursus maksimal 1000 karakter.');
            //     }
            // },
            'is_published' => 'required|boolean',
        ];
    }

    protected $messages = [
        'extra_description.required' => 'Deskripsi ekstra wajib diisi.',
        'extra_description.string' => 'Deskripsi ekstra harus berupa teks.',
    ];

    public function mount()
    {
        $this->course = Course::where('slug', $this->slug)->first();
        $this->extra_description = $this->course->extra_description;
        $this->is_published = $this->course->is_published;
        $this->dispatch('update-jodit-content', $this->course->extra_description);
    }

    public function save()
    {

        $this->extra_description = $this->processBase64Images($this->extra_description, 'course_images');

        $this->extra_description = Purifier::clean($this->extra_description, 'course_description');

        $data = $this->validate();
        $oldExtraDescription = '';
        if ($this->course->extra_description) {
            $oldExtraDescription = $this->course->extra_description;
        }
        $this->removeUnusedImages($oldExtraDescription, $this->extra_description, 'course_images');

        $this->course = Course::where('slug', $this->slug)->first();
        $this->course->update($data);
        flash()->success('Berhasil disimpan!', [], 'Sukses');
    }

    public function render()
    {
        return view('livewire.admin.course.steps.step-four');
    }
}
