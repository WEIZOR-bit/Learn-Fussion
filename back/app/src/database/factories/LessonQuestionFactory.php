<?php

namespace database\factories;

use App\Models\Lesson;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class LessonQuestionFactory extends Factory
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
            'lesson_id' => Lesson::factory(),
            'question_id' => Question::factory(),
        ];
    }
}
