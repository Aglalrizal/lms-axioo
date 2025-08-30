<?php

namespace App\Livewire\Admin\Course\Steps;

use App\Models\Course;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use App\Models\CourseContent;
use App\Models\CourseSyllabus;
use Livewire\Attributes\Layout;

#[Layout('layouts.dashboard')]
class StepThree extends Component
{
    public $slug;

    public $course;

    public $step = 3;

    public $syllabusToDelete;

    public $courseContentToDelete;

    public $isAddArticle = false;

    public $isAddQuiz = false;

    public $isAddVideo = false;

    public $isAddAssignment = false;

    public $syllabusId;

    public $courseContentId;

    public function updateCourseContentOrder($groups)
    {
        foreach ($groups as $group) {
            if ($group['order'] !== null) {
                CourseSyllabus::where('id', $group['value'])->update(['order' => $group['order']]);
            }
            foreach ($group['items'] as $item) {
                CourseContent::where('id', $item['value'])->update([
                    'order' => $item['order'],
                    'course_syllabus_id' => $group['value'],
                ]);
            }
        }
        flash()->success('Berhasil mengubah urutan konten', [], 'Sukses');
        $this->dispatch('refresh-syllabus');
    }
    public function updateSyllabusOrder($groups)
    {
        $changed = false;

        foreach ($groups as $group) {
            $syllabus = CourseSyllabus::find($group['value']);
            if ($syllabus && $syllabus->order != $group['order'] && $group['order'] !== null) {
                $syllabus->update(['order' => $group['order']]);
                $changed = true;
            }
        }

        if ($changed) {
            flash()->success('Berhasil mengubah urutan silabus', [], 'Sukses');
            CourseContent::recalculateGlobalOrder($this->course->id);
            $this->dispatch('refresh-syllabus');
        }
    }

    #[On('open-add-article')]
    public function openAddArticle($syllabusId, $courseContentId = null)
    {
        $this->isAddArticle = true;
        $this->isAddQuiz = false;
        $this->isAddVideo = false;
        $this->isAddAssignment = false;
        $this->syllabusId = $syllabusId;
        $this->courseContentId = $courseContentId;
    }

    #[On('open-add-quiz')]
    public function openAddQuiz($syllabusId = null, $courseContentId = null)
    {
        $this->isAddQuiz = true;
        $this->isAddArticle = false;
        $this->isAddVideo = false;
        $this->isAddAssignment = false;
        if ($syllabusId) {
            $this->syllabusId = $syllabusId;
        }
        $this->courseContentId = $courseContentId;

    }

    #[On('open-add-video')]
    public function openAddVideo($syllabusId, $courseContentId = null)
    {
        $this->isAddVideo = true;
        $this->isAddQuiz = false;
        $this->isAddArticle = false;
        $this->isAddAssignment = false;
        $this->syllabusId = $syllabusId;
        $this->courseContentId = $courseContentId;
    }

    #[On('open-add-assignment')]
    public function openAddAssignment($syllabusId = null, $courseContentId = null)
    {
        $this->isAddVideo = false;
        $this->isAddQuiz = false;
        $this->isAddArticle = false;
        $this->isAddAssignment = true;
        if ($syllabusId) {
            $this->syllabusId = $syllabusId;
        }
        $this->courseContentId = $courseContentId;
    }

    #[On('close-add-page')]
    public function closeCreateContentPage()
    {
        $this->reset(['syllabusId', 'courseContentId']);
        $this->isAddArticle = false;
        $this->isAddQuiz = false;
        $this->isAddVideo = false;
        $this->isAddAssignment = false;
    }

    #[On('delete-syllabus')]
    public function confirmDeleteSyllabus($id)
    {
        $this->syllabusToDelete = $id;

        sweetalert()
            ->showDenyButton()
            ->option('confirmButtonText', 'Iya, hapus!')
            ->option('denyButtonText', 'Batal')
            ->option('id', $id)
            ->warning('Apakah kamu yakin ingin menghapus silabus ini?', ['Confirm Deletion']);
    }

    #[On('delete-course-content')]
    public function confirmDeleteCourseContent($id)
    {
        $this->courseContentToDelete = CourseContent::find($id);

        sweetalert()
            ->showDenyButton()
            ->option('confirmButtonText', 'Iya, hapus!')
            ->option('denyButtonText', 'Batal')
            ->option('id', $id)
            ->warning("Apakah kamu yakin ingin menghapus {$this->courseContentToDelete->type_formatted} ini?", ['Confirm Deletion']);
    }

    #[On('sweetalert:confirmed')]
    public function delete(array $payload)
    {
        if ($this->syllabusToDelete) {
            $syllabus = CourseSyllabus::find($this->syllabusToDelete);
            if ($syllabus) {
                $syllabus->delete();
                flash()->success('Silabus berhasil dihapus!', [], 'Sukses');
            } else {
                flash()->error('Silabus tidak ditemukan.');
            }

            $this->syllabusToDelete = null;
            $this->refreshSyllabus();

            return;
        }
        if ($this->courseContentToDelete) {
            $courseContent = $this->courseContentToDelete;
            $type = Str::title($this->courseContentToDelete->type_formatted);
            if ($courseContent) {
                $courseContent->delete();
                flash()->success("{$type} berhasil dihapus.", [], 'Sukses');
            } else {
                flash()->error("{$type} tidak ditemukan.");
            }

            $this->courseContentToDelete = null;
            $this->refreshSyllabus();
        }
    }

    #[On('sweetalert:denied')]
    public function cancelDelete()
    {
        if ($this->syllabusToDelete) {
            $this->syllabusToDelete = null;
            // $this->dispatch('refresh-categories')->to(CreateFaqs::class);
            flash()->info('Membatalkan penghapusan silabus.', [], 'Informasi');
        }
        if ($this->courseContentToDelete) {
            flash()->info("Membatalkan penghapusan {$this->courseContentToDelete->type_formatted}.", [], 'Informasi');
            $this->courseContentToDelete = null;
        }
    }

    #[On('refresh-syllabus')]
    public function refreshSyllabus()
    {
        $this->course = Course::with([
            'syllabus' => fn ($q) => $q->orderBy('order'),
            'syllabus.courseContents' => fn ($q) => $q->orderBy('order'),
        ])->where('slug', $this->slug)->first();
    }

    public function mount()
    {
        $this->course = Course::with([
            'syllabus' => fn ($q) => $q->orderBy('order'),
            'syllabus.courseContents' => fn ($q) => $q->orderBy('order'),
        ])->where('slug', $this->slug)->first();
    }

    public function render()
    {
        return view('livewire.admin.course.steps.step-three');
    }
}
