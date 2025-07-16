<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\User;

class QuizAttemptFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = QuizAttempt::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'quiz_id' => Quiz::factory(),
            'user_id' => User::factory(),
            'start_time' => fake()->dateTime(),
            'end_time' => fake()->dateTime(),
            'total_score' => fake()->numberBetween(-10000, 10000),
            'status' => fake()->randomElement(["in_progress","submitted","graded"]),
        ];
    }
}
