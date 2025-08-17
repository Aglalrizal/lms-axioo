<?php

namespace App\Livewire\Course\CourseContents\Video;

use App\Models\Video;
use Livewire\Component;
use App\Models\CourseContent;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    public $syllabus_id;
    public $title;
    public $video_url;
    public $is_free_preview = false;
    public $short_description;
    public $courseContentId;
    public $courseContent;
    protected function rules()
    {
        return [
            'title'           => 'required|string|min:3|max:255',
            'video_url'       => 'required|url|max:255',
            'is_free_preview' => 'required|boolean',
            'short_description'         => [
                'nullable',
                'string',
                'max:150'
            ],
        ];
    }

    protected function messages()
    {
        return [
            'title.required'           => 'Judul video wajib diisi.',
            'title.min'                => 'Judul video minimal :min karakter.',
            'title.max'                => 'Judul video maksimal :max karakter.',
            'video_url.required'       => 'URL video wajib diisi.',
            'video_url.url'            => 'URL video tidak valid.',
            'is_free_preview.required' => 'Status preview wajib diisi.',
            'short_description.max'              => 'Deskripsi singkat maksimal :max karakter.',
        ];
    }

    public function mount()
    {
        if ($this->courseContentId) {
            $this->courseContent = CourseContent::with('video')->find($this->courseContentId);

            if ($this->courseContent) {
                $this->title           = $this->courseContent->title;
                $this->is_free_preview = (bool) $this->courseContent->is_free_preview;
                $this->video_url       = $this->courseContent->video->video_url;
                $this->short_description            = $this->courseContent->video->short_description;
                $this->syllabus_id     = $this->courseContent->course_syllabus_id;
            }
        }
    }

    public function save()
    {
        $validated = $this->validate();
        if ($this->courseContentId && $this->courseContent) {
            $this->courseContent->update( [
                'title'              => $validated['title'],
                'is_free_preview'    => $validated['is_free_preview'],
                'modified_by' => Auth::user()->username,
            ]);
            Video::where('course_content_id', $this->courseContent->id)->update([
                'short_description'              => $validated['short_description'],
                'video_url'         => $validated['video_url'],
            ]);

            flash()->success('Video pembelajaran berhasil diperbarui!', [], 'Sukses');
        } else {
            $lastOrder = CourseContent::where('course_syllabus_id', $this->syllabus_id)->max('order') ?? 0;
            CourseContent::create( [
                'course_syllabus_id' => $this->syllabus_id,
                'title'              => $validated['title'],
                'is_free_preview'    => $validated['is_free_preview'],
                'type'               => 'video',
                'order'              => $lastOrder + 1,
                'created_by'         => Auth::user()->username,
                'modified_by'        => Auth::user()->username,
            ])->video()->create(
                [
                    'short_description' => $validated['short_description'],
                    'video_url' => $validated['video_url'],
                ]
            );

            flash()->success('Video pembelajaran berhasil ditambahkan!', [], 'Sukses');
        }
        $this->dispatch('close-add-video');
        $this->dispatch('refresh-syllabus');
        $this->resetExcept('syllabus_id');
        $this->courseContentId = null;
    }

    public function close()
    {
        $this->dispatch('close-add-video');
        $this->reset();
    }
    public function render()
    {
        return view('livewire.course.course-contents.video.create');
    }
}
