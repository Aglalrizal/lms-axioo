<?php

namespace App\Livewire\Course;

use Livewire\Component;
use App\Models\CourseSyllabus;
use Mews\Purifier\Facades\Purifier;
use Illuminate\Support\Facades\Auth;
use App\Models\CourseContent as ModelsCourseContent;

class CourseContent extends Component
{
    public $syllabus_id;
    public $title;
    public $video_url;
    public $is_free_preview = false;
    public $content;
    public $courseContentId;
    public $courseContent;
    protected function rules()
    {
        return [
            'title'           => 'required|string|min:3|max:255',
            'video_url'       => 'nullable|url|max:255',
            'is_free_preview' => 'required|boolean',
            'content'         => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $plainText = trim(strip_tags($value));
                    if (strlen($plainText) < 20) {
                        $fail('Konten minimal 20 karakter.');
                    }
                }
            ],
        ];
    }

    protected function messages()
    {
        return [
            'title.required'           => 'Judul konten wajib diisi.',
            'title.min'                => 'Judul konten minimal :min karakter.',
            'title.max'                => 'Judul konten maksimal :max karakter.',
            'video_url.url'            => 'URL video tidak valid.',
            'is_free_preview.required' => 'Status preview wajib diisi.',
            'content.required'         => 'Konten wajib diisi.',
            'content.min'              => 'Konten minimal :min karakter.',
        ];
    }

    public function mount()
    {
        if ($this->courseContentId) {
            $this->courseContent = ModelsCourseContent::find($this->courseContentId);

            if ($this->courseContent) {
                $this->title           = $this->courseContent->title;
                $this->video_url       = $this->courseContent->video_url;
                $this->is_free_preview = (bool) $this->courseContent->is_free_preview;
                $this->content         = $this->courseContent->content;
                $this->syllabus_id     = $this->courseContent->course_syllabus_id;
            }
        }
    }

    public function save()
    {
        $this->content = Purifier::clean($this->content, 'course_description');
        $validated = $this->validate();

        if ($this->courseContentId && $this->courseContent) {
            $this->courseContent->update(array_merge($validated, [
                'modified_by' => Auth::user()->username,
            ]));

            flash()->success('Konten berhasil diperbarui!', [], 'Sukses');
        } else {
            $lastOrder = ModelsCourseContent::where('course_syllabus_id', $this->syllabus_id)->max('order') ?? 0;

            ModelsCourseContent::create(array_merge($validated, [
                'course_syllabus_id' => $this->syllabus_id,
                'order'              => $lastOrder + 1,
                'is_assessment'      => false,
                'created_by'         => Auth::user()->username,
                'modified_by'        => Auth::user()->username,
            ]));

            flash()->success('Konten berhasil ditambahkan!', [], 'Sukses');
        }
        $this->dispatch('close-add-content');
        $this->dispatch('refresh-syllabus');
        $this->resetExcept('syllabus_id');
        $this->courseContentId = null;
    }

    public function close()
    {
        $this->dispatch('close-add-content');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.course.course-content');
    }
}
