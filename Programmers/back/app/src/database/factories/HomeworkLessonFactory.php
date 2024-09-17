<?php

namespace Database\Factories;

use App\Models\Homework;
use App\Models\HomeworkLesson;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HomeworkLesson>
 */
class HomeworkLessonFactory extends Factory
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
            'lesson_id' => Lesson::factory(),
        ];
    }
}
