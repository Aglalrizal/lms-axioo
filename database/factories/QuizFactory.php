<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\CourseSyllabu;
use App\Models\CourseSyllabus;
use App\Models\Quiz;

class QuizFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Quiz::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'course_syllabus_id' => CourseSyllabus::factory(),
            'title' => fake()->sentence(4),
            'number_of_questions' => fake()->numberBetween(-10000, 10000),
            'duration' => fake()->numberBetween(-10000, 10000),
            'created_by' => fake()->word(),
            'modified_by' => fake()->word(),
        ];
    }
}
