<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Course;
use App\Models\CourseSyllabus;

class CourseSyllabusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CourseSyllabus::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'course_id' => Course::factory(),
            'title' => fake()->sentence(4),
            'order' => fake()->numberBetween(-10000, 10000),
            'is_completed' => fake()->boolean(),
            'created_by' => fake()->word(),
            'modified_by' => fake()->word(),
        ];
    }
}
