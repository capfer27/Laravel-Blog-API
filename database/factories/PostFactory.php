<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\PostStatus;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraphs(3, true),
            'status' => $this->faker->randomElement(PostStatus::cases()),
            'published_at' => $this->faker->optional(0.7)->dateTime(), // 70% this filed might be filled
            'moderated_at' => $this->faker->optional(0.9)->dateTime(),
            'created_at' => now(),
        ];
    }
}
