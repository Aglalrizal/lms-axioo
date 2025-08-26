<?php

namespace Database\Seeders;

use App\Models\LearningPath;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LearningPathSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all published courses to distribute among learning paths
        $publishedCourses = \App\Models\Course::where('is_published', true)->get();

        if ($publishedCourses->isEmpty()) {
            $this->command->warn('No published courses found. Learning Path steps will be created without courses.');
        }

        // Create sample learning paths with steps
        $paths = [
            [
                'title' => 'Full Stack Web Development',
                'description' => 'Comprehensive learning path to become a full stack web developer. Learn frontend, backend, and database technologies.',
                'is_published' => true,
                'created_by' => 'Admin',
                'modified_by' => 'Admin',
                'steps' => [
                    ['title' => 'HTML & CSS Fundamentals', 'description' => 'Learn the basics of HTML and CSS for web development'],
                    ['title' => 'JavaScript Programming', 'description' => 'Master JavaScript programming language and DOM manipulation'],
                    ['title' => 'React.js Framework', 'description' => 'Build modern web applications with React.js'],
                    ['title' => 'Node.js & Express', 'description' => 'Server-side development with Node.js and Express framework'],
                    ['title' => 'Database Design', 'description' => 'Learn database design principles and SQL'],
                ]
            ],
            [
                'title' => 'UI/UX Design Mastery',
                'description' => 'Complete learning path for UI/UX designers. From design principles to prototyping and user testing.',
                'is_published' => true,
                'created_by' => 'Admin',
                'modified_by' => 'Admin',
                'steps' => [
                    ['title' => 'Design Principles', 'description' => 'Fundamental principles of good design'],
                    ['title' => 'User Research', 'description' => 'Methods and techniques for understanding users'],
                    ['title' => 'Wireframing & Prototyping', 'description' => 'Create wireframes and interactive prototypes'],
                    ['title' => 'Visual Design', 'description' => 'Color theory, typography, and visual hierarchy'],
                ]
            ],
            [
                'title' => 'Data Science Foundations',
                'description' => 'Start your journey in data science. Learn Python, statistics, and machine learning basics.',
                'is_published' => true,
                'created_by' => 'Admin',
                'modified_by' => 'Admin',
                'steps' => [
                    ['title' => 'Python for Data Science', 'description' => 'Python programming fundamentals for data analysis'],
                    ['title' => 'Statistics & Probability', 'description' => 'Essential statistics concepts for data science'],
                    ['title' => 'Data Visualization', 'description' => 'Create meaningful visualizations with matplotlib and seaborn'],
                    ['title' => 'Machine Learning Basics', 'description' => 'Introduction to machine learning algorithms'],
                    ['title' => 'Data Analysis Projects', 'description' => 'Apply your skills to real-world data projects'],
                ]
            ],
            [
                'title' => 'Digital Marketing Strategy',
                'description' => 'Master digital marketing from SEO to social media marketing and analytics.',
                'is_published' => true, // Draft path
                'created_by' => 'Admin',
                'modified_by' => 'Admin',
                'steps' => [
                    ['title' => 'Digital Marketing Fundamentals', 'description' => 'Core concepts of digital marketing'],
                    ['title' => 'SEO & Content Marketing', 'description' => 'Search engine optimization and content strategy'],
                    ['title' => 'Social Media Marketing', 'description' => 'Marketing across social media platforms'],
                ]
            ]
        ];

        // Track used courses to avoid repetition within same learning path
        $usedCourseIds = [];

        foreach ($paths as $pathData) {
            $steps = $pathData['steps'];
            unset($pathData['steps']);

            $learningPath = LearningPath::factory()->create($pathData);

            // Reset used courses for each learning path
            $pathUsedCourses = [];

            // Create steps for this learning path
            foreach ($steps as $index => $stepData) {
                $stepData['order'] = $index + 1;
                $stepData['learning_path_id'] = $learningPath->id;

                // Get a course that hasn't been used in this path yet
                if ($publishedCourses->isNotEmpty()) {
                    $availableCourses = $publishedCourses->whereNotIn('id', $pathUsedCourses);

                    if ($availableCourses->isEmpty()) {
                        // If all courses used, reset and start over
                        $availableCourses = $publishedCourses;
                        $pathUsedCourses = [];
                    }

                    $selectedCourse = $availableCourses->random();
                    $stepData['course_id'] = $selectedCourse->id;
                    $pathUsedCourses[] = $selectedCourse->id;
                } else {
                    $stepData['course_id'] = null;
                }

                \App\Models\LearningPathStep::factory()->create($stepData);
            }
        }

        // Create additional random learning paths for testing
        // LearningPath::factory(5)
        //     ->published()
        //     ->create()
        //     ->each(function ($learningPath) use ($publishedCourses) {
        //         $stepCount = fake()->numberBetween(3, 8);
        //         $pathUsedCourses = [];

        //         for ($i = 1; $i <= $stepCount; $i++) {
        //             $courseId = null;

        //             if ($publishedCourses->isNotEmpty()) {
        //                 $availableCourses = $publishedCourses->whereNotIn('id', $pathUsedCourses);

        //                 if ($availableCourses->isEmpty()) {
        //                     $availableCourses = $publishedCourses;
        //                     $pathUsedCourses = [];
        //                 }

        //                 $selectedCourse = $availableCourses->random();
        //                 $courseId = $selectedCourse->id;
        //                 $pathUsedCourses[] = $selectedCourse->id;
        //             }

        //             \App\Models\LearningPathStep::factory()->create([
        //                 'learning_path_id' => $learningPath->id,
        //                 'course_id' => $courseId,
        //                 'order' => $i
        //             ]);
        //         }
        //     });
    }
}
