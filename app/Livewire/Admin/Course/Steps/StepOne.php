<?php

namespace App\Livewire\Admin\Course\Steps;

use App\Models\User;
use App\Models\Course;
use Livewire\Component;
use Livewire\Attributes\Rule;
use App\Models\CourseCategory;
use Livewire\Attributes\Layout;
use Mews\Purifier\Facades\Purifier;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.dashboard')]
class StepOne extends Component

{
    public $step = 1;
    public $categories;
    public $instructors;
    public $courseCategory,$courseInstructor,$title,$courseLevel,$courseType,$duration,$description;
    
    public ?Course $course = null;

    public $slug;

    public function rules()
    {
        return [
            'courseCategory'    => 'required|integer|exists:course_categories,id',
            'courseInstructor'  => 'required|integer|exists:users,id',
            'title'             => 'required|string|max:255',
            'courseLevel'       => 'required|string|max:100',
            'courseType'        => 'required|string|max:100',
            'duration'          => 'required|integer|min:1',
            'description'       => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $plainText = trim(strip_tags($value));
                    if (strlen($plainText) < 20) {
                        $fail('Deskripsi kursus minimal 20 karakter teks.');
                    }
                },
            ],
        ];
    }

    public function messages()
    {
        return [
            'courseCategory.required'  => 'Kategori kursus wajib dipilih.',
            'courseCategory.integer'   => 'Kategori kursus tidak valid.',
            'courseCategory.exists'    => 'Kategori kursus yang dipilih tidak ditemukan.',

            'courseInstructor.required'=> 'Instruktur wajib dipilih.',
            'courseInstructor.integer' => 'Instruktur tidak valid.',
            'courseInstructor.exists'  => 'Instruktur yang dipilih tidak ditemukan.',

            'title.required'           => 'Judul kursus wajib diisi.',
            'title.string'             => 'Judul kursus harus berupa teks.',
            'title.max'                => 'Judul kursus tidak boleh lebih dari :max karakter.',

            'courseLevel.required'     => 'Level kursus wajib dipilih.',
            'courseLevel.string'       => 'Level kursus harus berupa teks.',
            'courseLevel.max'          => 'Level kursus tidak boleh lebih dari :max karakter.',

            'courseType.required'      => 'Tipe kursus wajib dipilih.',
            'courseType.string'        => 'Tipe kursus harus berupa teks.',
            'courseType.max'           => 'Tipe kursus tidak boleh lebih dari :max karakter.',

            'duration.required'        => 'Durasi kursus wajib diisi.',
            'duration.integer'         => 'Durasi kursus harus berupa angka (jam/menit).',
            'duration.min'             => 'Durasi kursus minimal :min (jam/menit).',

            'description.required'     => 'Deskripsi kursus wajib diisi.',
            'description.string'       => 'Deskripsi kursus harus berupa teks.',
            'description.min'          => 'Deskripsi kursus minimal :min karakter.',
            'description.max'          => 'Deskripsi kursus maksimal :max karakter.',
        ];
    }
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
        $this->description = Purifier::clean($this->description);
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
