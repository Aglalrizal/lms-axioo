<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SupportTicket>
 */
class SupportTicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'full_name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'subject' => fake()->randomElement(['General', 'Technical', 'Accounts', 'Payment', 'Other']),
            'description' => fake()->paragraph(12),
            'status' => fake()->randomElement(['open', 'closed']),
        ];
    }
}
