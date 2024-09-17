<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->name(),
            'average_rating' => 0.0,
            'description' => fake()->text(),
            'review_count' => 0,
            'created_by' => Admin::factory(),
            'updated_by' => Admin::factory(),
        ];
    }
}
