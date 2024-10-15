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
            'updated_at' => now(),
            'category_id' => 3
        ]);


        DB::table('courses')->insert([
            'name' => 'Java',
            'average_rating' => 5,
            'description' => 'Java is a very simple language',
            'review_count' => 10,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            'category_id' => 2
        ]);


        DB::table('courses')->insert([
            'name' => 'Next.js',
            'average_rating' => 5,
            'description' => 'Next.js is a very simple JavaScript framework.',
            'review_count' => 5,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            'category_id' => 1
        ]);

        // first user finished courses
        DB::table('courses_finished')->insert([
            'course_id' => 1,
            'user_id' => 1,
            'finished_at' => now(),
        ]);

        DB::table('courses_finished')->insert([
            'course_id' => 1,
            'user_id' => 2,
            'finished_at' => now(),
        ]);
        DB::table('courses_finished')->insert([
            'course_id' => 1,
            'user_id' => 3,
            'finished_at' => now(),
        ]);

        // second user finished courses
        DB::table('courses_finished')->insert([
            'course_id' => 1,
            'user_id' => 2,
            'finished_at' => now(),
        ]);

        DB::table('courses_finished')->insert([
            'course_id' => 1,
            'user_id' => 2,
            'finished_at' => now(),
        ]);
        DB::table('courses_finished')->insert([
            'course_id' => 1,
            'user_id' => 2,
            'finished_at' => now(),
        ]);


        // third user finished courses
        DB::table('courses_finished')->insert([
            'course_id' => 1,
            'user_id' => 3,
            'finished_at' => now(),
        ]);

        DB::table('courses_finished')->insert([
            'course_id' => 1,
            'user_id' => 3,
            'finished_at' => now(),
        ]);
        DB::table('courses_finished')->insert([
            'course_id' => 1,
            'user_id' => 3,
            'finished_at' => now(),
        ]);






        DB::table('courses_reviews')->insert([
            'course_id' => 1,
            'user_id' => 1,
            'content' => 'Laravel is a very simple PHP framework.',
            'rating' => 5,
        ]);

        DB::table('courses_reviews')->insert([
            'course_id' => 2,
            'user_id' => 2,
            'content' => 'Laravel is a very simple PHP framework.',
            'rating' => 5,
        ]);


        DB::table('courses_reviews')->insert([
            'course_id' => 3,
            'user_id' => 3,
            'content' => 'Laravel is a very simple PHP framework.',
            'rating' => 5,
        ]);
    }
}
