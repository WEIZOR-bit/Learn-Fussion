<?php

namespace database\factories;

use App\Models\Lesson;
use app\Models\LessonReview;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LessonReview>
 */
class LessonReviewFactory extends Factory
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
            'content' => fake()->text(),
            'rating' => 0.0
        ];
    }
}
