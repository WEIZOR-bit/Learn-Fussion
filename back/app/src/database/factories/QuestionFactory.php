<?php

namespace Database\Factories;

use App\Models\Lesson;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Question>
 */
class QuestionFactory extends Factory
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
            'matter' => fake()->text(),
            'answers' => fake()->text() . '|',
            'lesson_id' => Lesson::factory(),
        ];
    }
}
