<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('courses')->insert([
            'name' => 'Laravel',
            'average_rating' => 5,
            'description' => 'Laravel is a very simple PHP framework.',
            'review_count' => 5,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('courses_finished')->insert([
            'course_id' => 1,
            'user_id' => 1,
            'finished_at' => now(),
        ]);

        DB::table('courses_reviews')->insert([
            'course_id' => 1,
            'user_id' => 1,
            'content' => 'Laravel is a very simple PHP framework.',
            'rating' => 5,
        ]);
    }
}
