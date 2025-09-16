<?php

namespace Database\Factories;

use App\Models\QuizAnswer;
use App\Models\QuizAttempt;
use App\Models\QuizQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizAnswerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = QuizAnswer::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'quiz_attempt_id' => QuizAttempt::factory(),
            'quiz_question_id' => QuizQuestion::factory(),
            'answer' => fake()->text(),
            'is_correct' => fake()->boolean(),
            'score' => fake()->numberBetween(-10000, 10000),
        ];
    }
}
