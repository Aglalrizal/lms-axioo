<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $course = Course::inRandomOrder()->first();
        $student = User::role('student')->inRandomOrder()->first();

        return [
            'course_id' => $course?->id ?? 1,
            'student_id' => $student?->id ?? 1,
            'quantity' => 1,
            'price' => $course?->price ?? $this->faker->randomFloat(2, 10000, 1000000),
            'status' => 'paid',
            'created_at' => $this->faker->dateTimeBetween('2025-01-01', '2025-12-31'),
            'updated_at' => $this->faker->dateTimeBetween('2025-01-01', '2025-12-31'),
        ];
    }
}
