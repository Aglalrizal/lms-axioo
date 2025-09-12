<?php

namespace App\Livewire\Admin\Course\Steps;

use App\Models\User;
use App\Models\Course;
use App\Models\Program;
use Livewire\Component;
use Livewire\Attributes\Rule;
use App\Models\category;
use App\Models\CourseCategory;
use Livewire\Attributes\Layout;
use App\Traits\HandlesBase64Images;
use Mews\Purifier\Facades\Purifier;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.dashboard')]
class StepOne extends Component
{
    use HandlesBase64Images;

    public $step = 1;
    public $categories;
    public $instructors;
    public $programs;
    public $category, $instructor, $program, $title, $level, $accessType, $duration, $description = '', $short_desc, $price;

    public ?Course $course = null;

    public $slug;

    public function rules()
    {
        return [
            'category'    => 'required|integer|exists:course_categories,id',
            'instructor'  => 'required|integer|exists:users,id',
            'program'        => 'nullable|integer|exists:programs,id',
            'title'             => 'required|string|max:255',
            'level'       => 'required|string|max:100',
            'accessType'        => 'required|string|max:100',
            'duration'          => 'required|integer|min:1',
            'description'       => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $plainText = trim(strip_tags($value));
                    if (strlen($plainText) < 100) {
                        $fail('Deskripsi kursus minimal 100 karakter teks.');
                    }
                },
            ],
            'short_desc' => 'required|string|min:75|max:150',
            'price' => 'nullable|numeric|min:0'
        ];
    }

    public function messages()
    {
        return [
            'category.required'  => 'Kategori kursus wajib dipilih.',
            'category.integer'   => 'Kategori kursus tidak valid.',
            'category.exists'    => 'Kategori kursus yang dipilih tidak ditemukan.',

            'instructor.required' => 'Instruktur wajib dipilih.',
            'instructor.integer' => 'Instruktur tidak valid.',
            'instructor.exists'  => 'Instruktur yang dipilih tidak ditemukan.',

            'title.required'           => 'Judul kursus wajib diisi.',
            'title.string'             => 'Judul kursus harus berupa teks.',
            'title.max'                => 'Judul kursus tidak boleh lebih dari :max karakter.',

            'level.required'     => 'Level kursus wajib dipilih.',
            'level.string'       => 'Level kursus harus berupa teks.',
            'level.max'          => 'Level kursus tidak boleh lebih dari :max karakter.',

            'accessType.required'      => 'Tipe kursus wajib dipilih.',
            'accessType.string'        => 'Tipe kursus harus berupa teks.',
            'accessType.max'           => 'Tipe kursus tidak boleh lebih dari :max karakter.',

            'duration.required'        => 'Durasi kursus wajib diisi.',
            'duration.integer'         => 'Durasi kursus harus berupa angka (jam/menit).',
            'duration.min'             => 'Durasi kursus minimal :min (jam/menit).',

            'description.required'     => 'Deskripsi kursus wajib diisi.',
            'description.string'       => 'Deskripsi kursus harus berupa teks.',
            'description.min'          => 'Deskripsi kursus minimal :min karakter.',
            'description.max'          => 'Deskripsi kursus maksimal :max karakter.',

            'short_desc.required'     => 'Deskripsi singkat wajib diisi.',
            'short_desc.string'       => 'Deskripsi singkat harus berupa teks.',
            'short_desc.min'          => 'Deskripsi singkat minimal :min karakter.',
            'short_desc.max'          => 'Deskripsi singkat maksimal :max karakter.',

            'price.numeric'           => 'Harga kursus harus berupa angka.',
            'price.min'               => 'Harga kursus tidak boleh negatif.',
        ];
    }
    public function mount()
    {
        if ($this->slug) {
            $this->course = Course::where('slug', $this->slug)->firstOrFail();
            if ($this->course) {
                $this->title = $this->course->title;
                $this->category = $this->course->course_category_id;
                $this->instructor = $this->course->teacher_id;
                $this->program = $this->course->program;
                $this->duration = $this->course->duration;
                $this->description = $this->course->description;
                $this->short_desc = $this->course->short_desc;
                $this->price = $this->course->price;
                $this->dispatch('update-jodit-content', [$this->description]);
                $this->level = $this->course->level->value;
                $this->accessType = $this->course->access_type->value;
            }
        }

        $this->categories = CourseCategory::all();
        $this->programs = Program::all();
        $this->instructors = User::role('instructor')->get();
    }


    public function stepOne()
    {
        $this->description = $this->processBase64Images($this->description, 'course_images');
        $this->description = Purifier::clean($this->description, 'course_description');

        $data = $this->validate();

        
        $data['program'] = $data['program'] ?: null;
        $data['price'] = $data['price'] ?: 0;
        
        if ($this->course && $this->course->exists) {
            $oldDescription = $this->course->description;
            $this->removeUnusedImages($oldDescription, $this->description, 'course_images');
            $data['description'] = $this->description;
            if ($this->title != $this->course->title) {
                $this->slug = '';
                $this->course->slug = "";
                $this->course->update([
                    'title' => $data['title'],
                    'course_category_id' => $data['category'],
                    'teacher_id' => $data['instructor'],
                    'program_id' => $data['program'],
                    'modified_by' => Auth::user()->username,
                    'level' => $data['level'],
                    'access_type' => $data['accessType'],
                    'description' => $data['description'],
                    'duration' => $data['duration'],
                    'short_desc' => $data['short_desc'],
                    'price' => $data['price']
                ]);
                flash()->success('Kursus Berhasil Diperbarui!', [], 'Sukses');
                $this->slug = $this->course->slug;
                $this->dispatch('set-course', ['slug' => $this->course->slug]);
                return redirect()->route('admin.course.create', ['slug' => $this->slug]);
            } else {
                $this->course->update([
                    'title' => $data['title'],
                    'course_category_id' => $data['category'],
                    'teacher_id' => $data['instructor'],
                    'program_id' => $data['program'],
                    'modified_by' => Auth::user()->username,
                    'level' => $data['level'],
                    'access_type' => $data['accessType'],
                    'description' => $data['description'],
                    'duration' => $data['duration'],
                    'short_desc' => $data['short_desc'],
                    'price' => $data['price']
                ]);
                flash()->success('Kursus Berhasil Diperbarui!', [], 'Sukses');
            }
        } else {
            $this->course = Course::create([
                'title' => $data['title'],
                'course_category_id' => $data['category'],
                'teacher_id' => $data['instructor'],
                'program_id' => $data['program'],
                'created_by' => Auth::user()->username,
                'modified_by' => Auth::user()->username,
                'level' => $data['level'],
                'access_type' => $data['accessType'],
                'is_published' => 0,
                'description' => $data['description'],
                'duration' => $data['duration'],
                'short_desc' => $data['short_desc'],
                'price' => $data['price'] ?? 0
            ]);
            flash()->success('Kursus Berhasil Disimpan!', [], 'Sukses');
            $this->slug = $this->course->slug;
            $this->dispatch('set-course', ['slug' => $this->course->slug]);
            return $this->redirect(route('admin.course.create', ['slug' => $this->slug]), true);
        }
    }
    public function render()
    {
        $this->categories = CourseCategory::all();
        $this->instructors = User::role('instructor')->get();
        return view('livewire.admin.course.steps.step-one');
    }
}
