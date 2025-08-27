<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\LearningPath;
use App\Models\LearningPathStep;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
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

    public $steps = [];

    // Track steps that should be deleted when saving
    public $stepsToDelete = [];

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'steps' => 'required|array|min:1',
            'steps.*.title' => 'required|string|max:255',
            'steps.*.description' => 'required|string',
            'steps.*.course_id' => 'required|exists:courses,id',
        ];
    }

    protected $messages = [
        'title.required' => 'Judul learning path wajib diisi.',
        'description.required' => 'Deskripsi learning path wajib diisi.',
        'steps.required' => 'Minimal harus ada 1 step.',
        'steps.min' => 'Minimal harus ada 1 step.',
        'steps.*.title.required' => 'Judul step wajib diisi.',
        'steps.*.description.required' => 'Deskripsi step wajib diisi.',
        'steps.*.course_id.required' => 'Course untuk step wajib dipilih.',
        'steps.*.course_id.exists' => 'Course yang dipilih tidak valid.',
    ];

    public function mount($slug)
    {
        $this->learningPath = LearningPath::with('steps')->where('slug', $slug)->firstOrFail();

        $this->title = $this->learningPath->title;
        $this->description = $this->learningPath->description;

        // Load existing steps with consistent temp_id generation
        $this->steps = $this->learningPath->steps->map(function ($step) {
            return [
                'id' => $step->id,
                'title' => $step->title,
                'description' => $step->description,
                'course_id' => $step->course_id,
                'temp_id' => 'existing_' . $step->id, // Consistent temp_id for existing steps
                'is_existing' => true
            ];
        })->toArray();

        // Initialize empty array for steps to delete
        $this->stepsToDelete = [];

        if (empty($this->steps)) {
            $this->addStep();
        }
    }

    public function addStep()
    {
        $this->steps[] = [
            'id' => null,
            'title' => '',
            'description' => '',
            'course_id' => null,
            'temp_id' => 'new_' . uniqid(),
            'is_existing' => false
        ];
    }

    public function removeStep($index)
    {
        if (count($this->steps) > 1) {
            $stepToRemove = $this->steps[$index];

            // If it's an existing step, mark it for deletion instead of deleting immediately
            if (isset($stepToRemove['id']) && $stepToRemove['id'] && $stepToRemove['is_existing']) {
                $this->stepsToDelete[] = $stepToRemove['id'];
            }

            // Remove from steps array
            unset($this->steps[$index]);
            $this->steps = array_values($this->steps); // Re-index array
        }
    }

    public function updateStepOrder($orderedIds)
    {
        $orderedSteps = [];
        foreach ($orderedIds as $tempId) {
            foreach ($this->steps as $step) {
                if ($step['temp_id'] == $tempId) {
                    $orderedSteps[] = $step;
                    break;
                }
            }
        }
        $this->steps = $orderedSteps;
    }

    public function save()
    {
        $this->validate();

        DB::transaction(function () {
            // Update Learning Path
            $this->learningPath->update([
                'title' => $this->title,
                'description' => $this->description,
                'modified_by' => Auth::user()->username,
            ]);

            // Delete marked steps
            if (!empty($this->stepsToDelete)) {
                LearningPathStep::whereIn('id', $this->stepsToDelete)->delete();
            }

            // Prepare batch operations
            $stepsToUpdate = [];
            $stepsToCreate = [];

            foreach ($this->steps as $index => $stepData) {
                if ($stepData['id'] && $stepData['is_existing']) {
                    // Existing step - prepare for batch update
                    $stepsToUpdate[] = [
                        'id' => $stepData['id'],
                        'title' => $stepData['title'],
                        'description' => $stepData['description'],
                        'course_id' => $stepData['course_id'],
                        'order' => $index + 1,
                    ];
                } else {
                    // New step - prepare for creation
                    $stepsToCreate[] = [
                        'learning_path_id' => $this->learningPath->id,
                        'course_id' => $stepData['course_id'],
                        'title' => $stepData['title'],
                        'description' => $stepData['description'],
                        'order' => $index + 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            // Perform batch operations
            if (!empty($stepsToUpdate)) {
                foreach ($stepsToUpdate as $stepUpdate) {
                    LearningPathStep::where('id', $stepUpdate['id'])->update([
                        'title' => $stepUpdate['title'],
                        'description' => $stepUpdate['description'],
                        'course_id' => $stepUpdate['course_id'],
                        'order' => $stepUpdate['order'],
                    ]);
                }
            }

            if (!empty($stepsToCreate)) {
                LearningPathStep::insert($stepsToCreate);
            }

            // Clear steps to delete array
            $this->stepsToDelete = [];

            flash()->success('Learning Path berhasil diperbarui!', [], 'Sukses');
            return $this->redirect(route('admin.learning-paths.index'), true);
        });
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
            ->orderBy('title')
            ->get();

        // Dispatch event to initialize sortable after render
        $this->dispatch('component-loaded');

        return view('livewire.learning-path-edit', [
            'courses' => $courses
        ]);
    }
}
