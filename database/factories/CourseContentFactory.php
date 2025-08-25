<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\CourseContent;
use App\Models\CourseSyllabu;
use App\Models\CourseSyllabus;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseContentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CourseContent::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'course_syllabus_id' => CourseSyllabus::factory(),
            'title' => fake()->sentence(4),
            'content' => fake()->paragraphs(3, true),
            'video_url' => fake()->word(),
            'order' => fake()->numberBetween(-10000, 10000),
            'is_free_preview' => fake()->boolean(),
            'is_assessment' => fake()->boolean(),
            'is_completed' => fake()->boolean(),
            'created_by' => fake()->word(),
            'modified_by' => fake()->word(),
        ];
    }
}
