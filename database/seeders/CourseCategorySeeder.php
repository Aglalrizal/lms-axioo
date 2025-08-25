<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CourseCategory;
use Illuminate\Support\Str;

class CourseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Software Engineering',
            'Graphic Design',
            'Web Development',
            'Mobile Development',
            'Data Science',
            'Digital Marketing',
            'UI/UX Design',
            'Machine Learning',
            'Cybersecurity',
            'Database Administration',
            'Project Management',
            'Content Writing',
            'Video Editing',
            'Photography',
            'Business Analytics'
        ];

        foreach ($categories as $category) {
            CourseCategory::insert([
                'name' => $category,
                'slug' => Str::slug($category),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
