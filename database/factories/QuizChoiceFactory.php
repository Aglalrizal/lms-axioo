<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\QuizChoice;
use App\Models\QuizQuestion;

class QuizChoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = QuizChoice::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'question_id' => QuizQuestion::factory(),
            'answer_option' => fake()->word(),
            'is_correct' => fake()->boolean(),
            'created_by' => fake()->word(),
            'modified_by' => fake()->word(),
        ];
    }
}
