<?php

namespace database\factories;

use App\Models\Course;
use app\Models\CourseFinished;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CourseFinished>
 */
class CourseFinishedFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'course_id' => Course::factory(),
            'user_id' => User::factory(),
            'finished_at' => now(),
        ];
    }
}
