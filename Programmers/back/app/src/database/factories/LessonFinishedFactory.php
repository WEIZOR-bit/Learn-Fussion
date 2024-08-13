<?php

namespace database\factories;

use App\Models\Lesson;
use app\Models\LessonFinished;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LessonFinished>
 */
class LessonFinishedFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lesson_id' => Lesson::factory(),
            'user_id' => User::factory(),
        ];
    }
}
