<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Program>
 */
class ProgramFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement([
                'Axioo',
                'Intel',
                'MakeBlock',
                'Axioo Robotic',
                'TelView Security Academy',
                'Cerdas Bersama ASABA',
                'Digital Development',
                'Axioo Live Skill to Job & Enterpreneur',
                'LS Cable',
                'IT Specialist',
                'EL Shaddai',
                'Fablab Makers Academy',
                'Metrix Flasher',
                'IT Smart Coding'
            ]),
        ];
    }
}
