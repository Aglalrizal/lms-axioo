<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = User::role('student')->get();
        $courses = Course::all();

        foreach ($students as $student) {
            $randomCourses = $courses->random(rand(1, 20));

            foreach ($randomCourses as $course) {
                Enrollment::create([
                    'transaction_id' => 1,
                    'student_id'     => $student->id,
                    'course_id'      => $course->id,
                    'enrolled_by'    => $student->id, // kalau self-enroll
                    'enrolled_at'    => now()->subDays(rand(0, 60)),
                    'created_by'     => $student->username,
                    'modified_by'    => $student->username,
                ]);
            }
        }
    }
}
