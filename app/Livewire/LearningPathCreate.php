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
class LearningPathCreate extends Component
{
    #[Rule('required|string|max:255')]
    public $title = '';

    #[Rule('required|string')]
    public $description = '';

    public $steps = [];

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

    public function mount()
    {
        $this->addStep();
    }

    public function addStep()
    {
        $this->steps[] = [
            'title' => '',
            'description' => '',
            'course_id' => null,
            'temp_id' => uniqid()
        ];
    }

    public function removeStep($index)
    {
        if (count($this->steps) > 1) {
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
            // Create Learning Path
            $learningPath = LearningPath::create([
                'title' => $this->title,
                'description' => $this->description,
                'is_published' => false,
                'created_by' => Auth::user()->username,
                'modified_by' => Auth::user()->username,
            ]);

            // Create Steps
            foreach ($this->steps as $index => $stepData) {
                LearningPathStep::create([
                    'learning_path_id' => $learningPath->id,
                    'course_id' => $stepData['course_id'],
                    'title' => $stepData['title'],
                    'description' => $stepData['description'],
                    'order' => $index + 1,
                ]);
            }

            flash()->success('Learning Path berhasil dibuat!', [], 'Sukses');
            return $this->redirect(route('admin.learning-paths.index'));
        });
    }

    public function render()
    {
        $courses = Course::where('is_published', true)
            ->orderBy('title')
            ->get();

        $this->dispatch('component-loaded');

        return view('livewire.learning-path-create', [
            'courses' => $courses
        ]);
    }
}
