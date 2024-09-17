<?php

namespace database\factories;

use App\Models\Admin;
use app\Models\Challenge;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Challenge>
 */
class ChallengeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->title(),
            'description' => $this->faker->paragraph(),
            'reward' => $this->faker->randomFloat(0,1,255),
            'created_by' => Admin::factory(),
            'updated_by' => Admin::factory(),
        ];
    }
}
