<?php

namespace Database\Factories;

use App\Models\Homework;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Homework>
 */
class HomeworkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'task' => fake()->unique()->name(),
            'created_by' => fake()->firstName(),
            'updated_by' => fake()->firstName(),
        ];
    }
}
