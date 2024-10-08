<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeagueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('leagues')->insert([
            ['name' => 'Beginner', 'min_mastery_level' => 0],
            ['name' => 'Intermediate', 'min_mastery_level' => 1000],
            ['name' => 'Advanced', 'min_mastery_level' => 5000],
            ['name' => 'Master', 'min_mastery_level' => 10000],
        ]);
    }
}
