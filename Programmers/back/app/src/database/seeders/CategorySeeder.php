<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            'name' => 'IT',
        ]);
        DB::table('categories')->insert([
            'name' => 'Design',
        ]);

        DB::table('categories')->insert([
            'name' => 'cybersecurity',
        ]);

        DB::table('categories')->insert([
            'name' => 'marketing',
        ]);

    }
}
