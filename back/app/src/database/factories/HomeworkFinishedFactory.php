<?php

namespace database\factories;

use App\Models\Homework;
use app\Models\HomeworkFinished;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HomeworkFinished>
 */
class HomeworkFinishedFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'homework_id' => Homework::factory(),
            'user_id' => User::factory(),
        ];
    }
}
