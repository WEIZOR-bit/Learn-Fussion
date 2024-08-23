<?php

namespace database\factories;

use app\Models\ForumPost;
use app\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ForumPost>
 */
class ForumPostFactory extends Factory
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
            'is_premium' => false,
            'user_id' => User::factory(),
        ];
    }
}
