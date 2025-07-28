<?php

namespace App\Livewire\Admin\Course\Steps;

use App\Models\User;
use App\Models\Course;
use Livewire\Component;
use Livewire\Attributes\Rule;
use App\Models\CourseCategory;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.dashboard')]
class StepOne extends Component

{
    public $step = 1;
    public $categories;
    public $instructors;
    #[Rule('required')]
    public $courseCategory;
    #[Rule('required')]
    public $courseInstructor;
    #[Rule('required')]
    public $title;
    #[Rule('required')]
    public $courseLevel;
    #[Rule('required')]
    public $courseType;
    #[Rule('required')]
    public $duration;
    #[Rule('required')]
    public $description;
    
    public ?Course $course = null;

    public $slug;

    public function mount()
    {
        if ($this->slug) {
            $this->course = Course::where('slug', $this->slug)->firstOrFail();
            if ($this->course) {
                $this->title = $this->course->title;
                $this->courseCategory = $this->course->course_category_id;
                $this->courseInstructor = $this->course->teacher_id;
                $this->duration = $this->course->duration;
                $this->description = $this->course->description;
                $this->dispatch('update-jodit-content', [$this->description]);
                $this->dispatch('init-category', [
                    $this->courseCategory
                ]);
                $this->dispatch('init-instructor', [
                    $this->courseInstructor
                ]);
                $this->courseLevel = $this->course->level;
                $this->courseType = $this->course->course_type;
            }
        }

        $this->categories = CourseCategory::all();
        $this->instructors = User::role('instructor')->get();
    }


    public function stepOne(){
        $data = $this->validate();
        if ($this->course && $this->course->exists) {
            if($this->title != $this->course->title){
                $this->slug = '';
                $this->course->slug = "";
                $this->course->update([
                    'title' => $data['title'],
                    'course_category_id' => $data['courseCategory'],
                    'teacher_id' => $data['courseInstructor'],
                    'modified_by' => Auth::user()->username,
                    'level' => $data['courseLevel'],
                    'course_type' => $data['courseType'],
                    'description' => $data['description'],
                    'duration' => $data['duration'],
                ]);
                flash()->success('Kursus Berhasil Diperbarui!', 'Sukses');
                $this->slug = $this->course->slug;
                $this->dispatch('set-course', ['slug' => $this->course->slug]);
                return redirect()->route('admin.course.create', ['slug' => $this->slug]);
            }else{
                $this->course->update([
                    'title' => $data['title'],
                    'course_category_id' => $data['courseCategory'],
                    'teacher_id' => $data['courseInstructor'],
                    'modified_by' => Auth::user()->username,
                    'level' => $data['courseLevel'],
                    'course_type' => $data['courseType'],
                    'description' => $data['description'],
                    'duration' => $data['duration'],
                ]);
                flash()->success('Kursus Berhasil Diperbarui!', [],'Sukses');
            }
        } else {
            $this->course = Course::create([
                'title' => $data['title'],
                'course_category_id' => $data['courseCategory'],
                'teacher_id' => $data['courseInstructor'],
                'created_by' => Auth::user()->username,
                'modified_by' => Auth::user()->username,
                'level' => $data['courseLevel'],
                'course_type' => $data['courseType'],
                'is_published' => 0,
                'description' => $data['description'],
                'duration' => $data['duration'],
            ]);
            flash()->success('Kursus Berhasil Disimpan!', [], 'Sukses');
            $this->slug = $this->course->slug;
            $this->dispatch('set-course', ['slug' => $this->course->slug]);
            return $this->redirect(route('admin.course.create', ['slug' => $this->slug]), true);
        }
    }
    public function render()
    {   $this->categories = CourseCategory::all();
        $this->instructors = User::role('instructor')->get();
        return view('livewire.admin.course.steps.step-one');
    }
}
