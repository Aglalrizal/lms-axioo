<?php

namespace Database\Factories;

use App\Enums\TicketStatus;
use App\Enums\TicketSubject;
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
            'subject' => fake()->randomElement(TicketSubject::values()),
            'description' => fake()->paragraph(12),
            'status' => fake()->randomElement(TicketStatus::values()),
        ];
    }
}
