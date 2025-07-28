<?php

namespace Database\Factories;

use App\Models\BlogCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $blogCategoryId = BlogCategory::inRandomOrder()->first()->id;

        return [
            'title' => fake()->sentence(),
            'slug' => fake()->slug(),
            'content' => fake()->paragraphs(4, true),
            'status' => fake()->randomElement(['published', 'drafted', 'scheduled']),
            'user_id' => rand(1, 2),
            'blog_category_id' => $blogCategoryId,
        ];
    }
}
