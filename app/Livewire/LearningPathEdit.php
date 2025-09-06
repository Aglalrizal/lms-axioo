<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\LearningPath;
use App\Models\LearningPathStep;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.dashboard')]
class LearningPathEdit extends Component
{
    public LearningPath $learningPath;

    #[Rule('required|string|max:255')]
    public $title = '';

    #[Rule('required|string')]
    public $description = '';

    public $stepToDelete = null;

    public function mount($slug)
    {
        $this->learningPath = LearningPath::where('slug', $slug)->firstOrFail();
        $this->title = $this->learningPath->title;
        $this->description = $this->learningPath->description;

        // Ensure at least one step exists
        if ($this->learningPath->steps()->count() == 0) {
            $this->addStep();
        }
    }

    public function addStep()
    {
        // Auto-save new step like FAQ implementation
        $maxOrder = LearningPathStep::where('learning_path_id', $this->learningPath->id)->max('order') ?? 0;

        // Ambil course pertama sebagai default karena course_id required di database
        $firstCourse = Course::where('is_published', true)->first();

        if (!$firstCourse) {
            flash()->error('Tidak ada kursus yang tersedia untuk dijadikan default. Buat kursus terlebih dahulu.', [], 'Error');
            return;
        }

        LearningPathStep::create([
            'learning_path_id' => $this->learningPath->id,
            'title' => 'Langkah Baru',
            'description' => 'Deskripsi langkah baru',
            'course_id' => $firstCourse->id, // Set ke course pertama, bukan null
            'order' => $maxOrder + 1,
        ]);

        flash()->success('Langkah baru berhasil ditambahkan!', [], 'Sukses');
    }
    public function updateStep($stepId, $field, $value)
    {
        // Update database directly like FAQ
        LearningPathStep::where('id', $stepId)
            ->where('learning_path_id', $this->learningPath->id)
            ->update([$field => $value]);

        flash()->success('Data berhasil diperbarui!', [], 'Sukses');
    }

    #[On('delete-step')]
    public function confirmDeleteStep($id)
    {
        $stepCount = LearningPathStep::where('learning_path_id', $this->learningPath->id)->count();

        if ($stepCount <= 1) {
            flash()->error('Minimal harus ada 1 langkah!', [], 'Error');
            return;
        }

        $this->stepToDelete = $id;

        sweetalert()
            ->showDenyButton()
            ->option('confirmButtonText', 'Ya, hapus ini!')
            ->option('denyButtonText', 'Batal')
            ->option('id', $id)
            ->warning('Apakah Anda yakin ingin menghapus langkah pembelajaran ini?', ['Konfirmasi Penghapusan']);
    }

    #[On('sweetalert:confirmed')]
    public function deleteStep(array $payload)
    {
        if ($this->stepToDelete) {
            $step = LearningPathStep::where('id', $this->stepToDelete)
                ->where('learning_path_id', $this->learningPath->id)
                ->first();

            if ($step) {
                $step->delete();
                flash()->success('Langkah berhasil dihapus!', [], 'Sukses');
            } else {
                flash()->error('Langkah tidak ditemukan.', [], 'Error');
            }

            $this->stepToDelete = null;
        }
    }

    #[On('sweetalert:denied')]
    public function cancelDeleteStep()
    {
        if ($this->stepToDelete) {
            $this->stepToDelete = null;
            flash()->info('Penghapusan langkah dibatalkan.', [], 'Info');
        }
    }

    public function updateStepOrder($orderedData)
    {
        // Auto-save like FAQ implementation - simple and clean
        foreach ($orderedData as $item) {
            $stepId = $item['value'];
            $newOrder = $item['order'];

            // Only update existing steps (ignore new steps that haven't been saved yet)
            if (is_numeric($stepId)) {
                LearningPathStep::where('id', $stepId)
                    ->where('learning_path_id', $this->learningPath->id)
                    ->update(['order' => $newOrder]);
            }
        }

        flash()->success('Urutan langkah berhasil diperbarui!', [], 'Sukses');
        // Don't refresh steps to avoid breaking sortable
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $this->learningPath->update([
            'title' => $this->title,
            'description' => $this->description,
            'modified_by' => Auth::user()->username,
        ]);

        flash()->success('Learning Path berhasil diperbarui!', [], 'Sukses');
    }

    public function togglePublish($pathId)
    {
        $path = LearningPath::findOrFail($pathId);
        $path->update(['is_published' => !$path->is_published]);

        $status = $path->is_published ? 'dipublikasikan' : 'di-unpublish';
        flash()->success("Learning Path berhasil {$status}!", [], 'Sukses');

        // Update local model
        $this->learningPath = $path;
    }

    public function render()
    {
        $courses = Course::where('is_published', true)
            ->select('id', 'title')
            ->orderBy('title')
            ->get();

        return view('livewire.learning-path-edit', [
            'courses' => $courses
        ]);
    }
}
