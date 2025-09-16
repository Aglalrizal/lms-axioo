<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\ContactUs;
use App\Models\Course;
use App\Models\SupportTicket;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            FaqCategorySeeder::class,
            FaqSeeder::class,
            BlogCategorySeeder::class,
            CourseCategorySeeder::class,
            ProgramSeeder::class,
            TransactionSeeder::class,
            EnrollmentSeeder::class,
        ]);

        // akun admin
        $admin = User::factory()->create([
            'username' => 'Admin',
            'email' => 'super@admin.com',
            'password' => Hash::make('password'),
        ]);
        $admin2 = User::factory()->create([
            'username' => 'Admin 2',
            'email' => 'super2@admin.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('super-admin');
        $instructor = User::factory()->create([
            'username' => 'Instructor',
            'email' => 'instructor@test.com',
            'password' => Hash::make('password'),
        ]);
        $student = User::factory()->create([
            'username' => 'student',
            'email' => 'student@test.com',
            'password' => Hash::make('password'),
        ]);
        $student->assignRole('student');
        $instructor->assignRole('instructor');
        $manageFaq = Permission::firstOrCreate(['name' => 'manage faqs']);
        $admin->givePermissionTo($manageFaq);
        $admin2->givePermissionTo($manageFaq);

        // dummy akun admin
        User::factory(3)->create()->each(function ($user) {
            $user->assignRole('admin');
        });
        // dummy akun students
        User::factory(50)->create()->each(function ($user) {
            $user->assignRole('student');
        });

        // dummy akun instructors
        User::factory(50)->create()->each(function ($user) {
            $user->assignRole('instructor');
        });

        SupportTicket::factory(50)->create();
        ContactUs::factory(50)->create();
        // Blog::factory(50)->create();

        // Create courses - semua akan otomatis dapat thumbnail dari samples
        Course::factory()
            ->withBase64Images()
            ->published()
            ->withProgram()
            ->count(50)
            ->create();

        // Create special courses with detailed syllabus and content
        $this->call([
            CourseContentSeeder::class,
        ]);

        Blog::factory()
            ->withBase64Images()
            ->count(50)
            ->create();

        // Create learning paths with steps
        $this->call([
            LearningPathSeeder::class,
        ]);
    }
}
