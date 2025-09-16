<?php

namespace App\Livewire\Course\CourseContents\Assignment;

use App\Models\CourseContent;
use App\Traits\HandlesBase64Images;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mews\Purifier\Facades\Purifier;

class Create extends Component
{
    use HandlesBase64Images, WithFileUploads;

    public $courseId;

    public $syllabus_id;

    public $title;

    public $url;

    public $file;

    public $instruction;

    public $courseContentId;

    public $courseContent;

    protected function rules()
    {
        return [
            'title' => 'required|string|min:3|max:255',
            'instruction' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $plainText = trim(strip_tags($value));
                    if (strlen($plainText) < 50) {
                        $fail('Instruksi minimal 50 karakter.');
                    }
                },
            ],
            'url' => 'nullable',
            'file' => 'nullable|file|max:10240',
        ];
    }

    protected function messages()
    {
        return [
            'title.required' => 'Judul artikel wajib diisi.',
            'title.min' => 'Judul artikel minimal :min karakter.',
            'title.max' => 'Judul artikel maksimal :max karakter.',
            'instruction.required' => 'Instruksi wajib diisi.',
            'instruction.min' => 'Instruksi minimal :min karakter.',
            'file.max' => 'Dokumen yang diunggah maksimal sebesar :max',
        ];
    }

    public function mount()
    {
        if ($this->courseContentId) {
            $this->courseContent = CourseContent::with(['assignment', 'courseSyllabus.course'])->find($this->courseContentId);

            if ($this->courseContent) {
                $this->title = $this->courseContent->title;
                $this->syllabus_id = $this->courseContent->course_syllabus_id;
                $this->instruction = $this->courseContent->assignment->instruction;
                $this->url = $this->courseContent->assignment->url;
                $this->file = $this->courseContent->assignment->file_path;
            }
        }
    }

    public function save()
    {
        $this->instruction = $this->processBase64Images($this->instruction, 'course_assignment_images');
        $this->instruction = Purifier::clean($this->instruction, 'course_description');
        $validated = $this->validate();

        $filePath = null;
        if (isset($validated['file']) && $validated['file'] instanceof \Illuminate\Http\UploadedFile) {
            $filePath = $validated['file']->store('course_assignment_files', 'public');
        }

        if ($this->courseContentId && $this->courseContent) {
            $oldInstruction = $this->courseContent->assignment->instruction ?? null;
            $oldFile = $this->courseContent->assignment->file_path;

            $this->courseContent->update([
                'title' => $validated['title'],
                'modified_by' => Auth::user()->username,
            ]);

            if ($filePath && $oldFile) {
                Storage::disk('public')->delete($oldFile);
            }

            $this->courseContent->assignment()->update([
                'instruction' => $validated['instruction'],
                'url' => $validated['url'],
                'file_path' => $filePath ?: $oldFile,
            ]);

            $this->removeUnusedImages($oldInstruction, $this->instruction, 'course_assignment_images');

            flash()->success('Tugas berhasil diperbarui!', [], 'Sukses');
        } else {
            $lastOrder = CourseContent::where('course_syllabus_id', $this->syllabus_id)->max('order') ?? 0;

            $this->courseContent = CourseContent::create([
                'course_id' => $this->courseId,
                'course_syllabus_id' => $this->syllabus_id,
                'title' => $validated['title'],
                'type' => 'assignment',
                'order' => $lastOrder + 1,
                'created_by' => Auth::user()->username,
                'modified_by' => Auth::user()->username,
            ]);

            $this->courseContent->assignment()->create([
                'instruction' => $validated['instruction'],
                'url' => $validated['url'],
                'file_path' => $filePath,
            ]);

            $this->courseContent->load('assignment');

            flash()->success('Tugas berhasil dibuat!', [], 'Sukses');
        }

        $this->dispatch('close-add-page');
    }

    public function close()
    {
        $this->dispatch('close-add-page');
        $this->reset();
    }

    public function confirmDelete()
    {
        sweetalert()
            ->showConfirmButton()
            ->showDenyButton()
            ->option('confirmButtonText', 'Iya hapus!')
            ->option('denyButtonText', 'Batal')
            ->warning('Apakah kamu yakin ingin menghapus dokumen ini?');
    }

    #[On('sweetalert:confirmed')]
    public function deleteFile()
    {
        Storage::delete($this->courseContent->assignment->file_path);
        $this->courseContent->assignment->update(
            ['file_path' => null]
        );
        flash()->success('Berhasil menghapus dokumen!', [], 'Sukses');
    }

    #[On('sweetalert:denied')]
    public function cancelDelete()
    {
        flash()->info('Penghapusan dokumen dibatalkan', [], 'Informasi');
    }

    public function render()
    {
        return view('livewire.course.course-contents.assignment.create');
    }
}
