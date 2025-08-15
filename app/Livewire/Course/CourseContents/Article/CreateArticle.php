<?php

namespace App\Livewire\Course\CourseContents\Article;

use App\Models\Article;
use Livewire\Component;
use App\Models\CourseContent;
use App\Traits\HandlesBase64Images;
use Mews\Purifier\Facades\Purifier;
use Illuminate\Support\Facades\Auth;

class CreateArticle extends Component
{
    use HandlesBase64Images;

    public $syllabus_id;
    public $title;
    public $video_url;
    public $is_free_preview = false;
    public $body;
    public $courseContentId;
    public $courseContent;
    protected function rules()
    {
        return [
            'title'           => 'required|string|min:3|max:255',
            'video_url'       => 'nullable|url|max:255',
            'is_free_preview' => 'required|boolean',
            'body'         => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $plainText = trim(strip_tags($value));
                    if (strlen($plainText) < 150) {
                        $fail('Artikel minimal 150 karakter.');
                    }
                }
            ],
        ];
    }

    protected function messages()
    {
        return [
            'title.required'           => 'Judul artikel wajib diisi.',
            'title.min'                => 'Judul artikel minimal :min karakter.',
            'title.max'                => 'Judul artikel maksimal :max karakter.',
            'video_url.url'            => 'URL video tidak valid.',
            'is_free_preview.required' => 'Status preview wajib diisi.',
            'body.required'         => 'Artikel wajib diisi.',
            'body.min'              => 'Artikel minimal :min karakter.',
        ];
    }

    public function mount()
    {
        if ($this->courseContentId) {
            $this->courseContent = CourseContent::with('article')->find($this->courseContentId);

            if ($this->courseContent) {
                $this->title           = $this->courseContent->title;
                $this->is_free_preview = (bool) $this->courseContent->is_free_preview;
                $this->body            = $this->courseContent->article->body;
                $this->video_url       = $this->courseContent->article->video_url;
                $this->syllabus_id     = $this->courseContent->course_syllabus_id;
            }
        }
    }

    public function save()
    {
        $this->body = Purifier::clean($this->body, 'course_description');
        $validated = $this->validate();
        if ($this->courseContentId && $this->courseContent) {
            $oldBody = $this->courseContent->article->body;
            $this->body = $this->processBase64Images($this->body, 'course_article_images');
            $this->courseContent->update( [
                'title'              => $validated['title'],
                'is_free_preview'    => $validated['is_free_preview'],
                'modified_by' => Auth::user()->username,
            ]);
            Article::where('course_content_id', $this->courseContent->id)->update([
                'body'              => $validated['body'],
                'video_url'         => $validated['video_url'],
            ]);

            $this->removeUnusedImages($oldBody, $this->body, 'course_article_images');

            flash()->success('Konten berhasil diperbarui!', [], 'Sukses');
        } else {
            $lastOrder = CourseContent::where('course_syllabus_id', $this->syllabus_id)->max('order') ?? 0;
            CourseContent::create( [
                'course_syllabus_id' => $this->syllabus_id,
                'title'              => $validated['title'],
                'is_free_preview'    => $validated['is_free_preview'],
                'type'               => 'article',
                'order'              => $lastOrder + 1,
                'created_by'         => Auth::user()->username,
                'modified_by'        => Auth::user()->username,
            ])->article()->create(
                [
                    'body' => $validated['body'],
                    'video_url' => $validated['video_url'],
                ]
            );

            flash()->success('Artikel berhasil dibuat!', [], 'Sukses');
        }
        $this->dispatch('close-add-article');
        $this->dispatch('refresh-syllabus');
        $this->resetExcept('syllabus_id');
        $this->courseContentId = null;
    }

    public function close()
    {
        $this->dispatch('close-add-article');
        $this->reset();
    }
    public function render()
    {
        return view('livewire.course.course-contents.article.create-article');
    }
}
