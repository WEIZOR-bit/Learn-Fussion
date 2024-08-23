<?php

namespace database\factories;

use app\Models\ForumPost;
use app\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ForumLikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'post_id' => ForumPost::factory(),
            'user_id' => User::factory(),
        ];
    }
}
