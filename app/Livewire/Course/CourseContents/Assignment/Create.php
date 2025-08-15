<?php

namespace App\Livewire\Course\CourseContents\Assignment;

use App\Models\Article;
use App\Models\Assignment;
use Livewire\Component;
use App\Models\CourseContent;
use App\Traits\HandlesBase64Images;
use Mews\Purifier\Facades\Purifier;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    use HandlesBase64Images;
    public $courseId;
    public $syllabus_id;
    public $title;
    public $instruction;
    public $courseContentId;
    public $courseContent;
    protected function rules()
    {
        return [
            'title'           => 'required|string|min:3|max:255',
            'instruction'         => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $plainText = trim(strip_tags($value));
                    if (strlen($plainText) > 50) {
                        $fail('Instruksi minimal 50 karakter.');
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
            'instruction.required'         => 'Instruksi wajib diisi.',
            'instruction.min'              => 'Instruksi minimal :min karakter.',
        ];
    }

    public function mount()
    {
        if ($this->courseContentId) {
            $this->courseContent = CourseContent::with(['assignment', 'courseSyllabus.course'])->find($this->courseContentId);

            if ($this->courseContent) {
                $this->title           = $this->courseContent->title;
                $this->instruction     = $this->courseContent->assignment->instruction;
                $this->syllabus_id     = $this->courseContent->course_syllabus_id;
            }
        }
    }

    public function save()
    {
        $this->instruction = Purifier::clean($this->instruction, 'course_description');
        $validated = $this->validate();
        if ($this->courseContentId && $this->courseContent) {
            $oldInstruction = $this->courseContent->article->instruction;
            $this->instruction = $this->processBase64Images($this->instruction, 'course_assignment_images');
            $this->courseContent->update( [
                'title'       => $validated['title'],
                'modified_by' => Auth::user()->username,
            ]);
            Assignment::where('course_content_id', $this->courseContent->id)->update([
                'instruction'       => $validated['instruction'],
            ]);

            $this->removeUnusedImages($oldInstruction, $this->instruction, 'course_article_images');

            flash()->success('Assignment berhasil diperbarui!', [], 'Sukses');
        } else {
            $lastOrder = CourseContent::where('course_syllabus_id', $this->syllabus_id)->max('order') ?? 0;
            CourseContent::create( [
                'course_syllabus_id' => $this->syllabus_id,
                'title'              => $validated['title'],
                'type'               => 'assignment',
                'order'              => $lastOrder + 1,
                'created_by'         => Auth::user()->username,
                'modified_by'        => Auth::user()->username,
            ])->assignment()->create(
                [
                    'instruction' => $validated['instruction'],
                ]
            );

            flash()->success('Assignment berhasil dibuat!', [], 'Sukses');
        }
        $this->dispatch('close-add-assignment');
        $this->dispatch('refresh-syllabus');
        $this->resetExcept('syllabus_id');
        $this->courseContentId = null;
    }

    public function close()
    {
        $this->dispatch('close-add-assignment');
        $this->reset();
    }
    public function render()
    {
        return view('livewire.course.course-contents.assignment.create');
    }
}
