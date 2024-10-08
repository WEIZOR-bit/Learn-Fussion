<?php

namespace database\factories;

use app\Models\Friend;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends Factory<Friend>
 */
class FriendFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id_1' => User::factory(),
            'user_id_2' => User::factory(),
        ];
    }
}
