<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $categories = ['academic', 'events', 'announcement', 'campus_life', 'help_wanted'];

        return [
            'user_id' => User::factory(),
            'post_content' => fake()->sentences(asText: true),
            'category' => fake()->randomElement($categories),
            'link' => fake()->optional(0.3)->url(),
            'image' => null,
            'status' => 'active',
        ];
    }
}
