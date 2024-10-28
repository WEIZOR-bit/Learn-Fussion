<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order' => $this->faker->numberBetween(1, 10),
            'name' => fake()->unique()->name(),
            'description' => fake()->text(),
            'tutorial_link' => fake()->url(),
            'question_count' => 0,
            'created_by' => Admin::factory(),
            'updated_by' => Admin::factory(),
            'course_id' => Course::factory(),
        ];
    }
}
