<?php

namespace database\factories;

use app\Models\ForumPost;
use app\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ForumCommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => $this->faker->realText(),
            'post_id' => ForumPost::factory(),
            'user_id' => User::factory(),
        ];
    }
}
