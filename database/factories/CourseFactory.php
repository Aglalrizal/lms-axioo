<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\User;

class CourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Course::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'teacher_id' => User::factory(),
            'course_category_id' => CourseCategory::factory(),
            'description' => fake()->text(),
            'thumbnail' => fake()->word(),
            'level' => fake()->randomElement(["beginner","intermediate","advanced"]),
            'duration' => fake()->numberBetween(-10000, 10000),
            'extra_description' => fake()->text(),
            'is_published' => fake()->boolean(),
            'created_by' => fake()->word(),
            'modified_by' => fake()->word(),
        ];
    }
}
