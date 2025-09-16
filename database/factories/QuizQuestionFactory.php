<?php

namespace Database\Factories;

use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizQuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = QuizQuestion::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'quiz_id' => Quiz::factory(),
            'question' => fake()->text(),
            'question_type' => fake()->randomElement(['multiple_choice', 'short_answer', 'true_false']),
            'score' => fake()->numberBetween(-10000, 10000),
            'order' => fake()->numberBetween(-10000, 10000),
            'created_by' => fake()->word(),
            'modified_by' => fake()->word(),
        ];
    }
}
