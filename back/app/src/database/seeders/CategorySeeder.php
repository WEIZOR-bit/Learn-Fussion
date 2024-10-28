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
            'name' => 'UI/UX Design',
        ]);

        DB::table('categories')->insert([
            'name' => 'Cybersecurity',
        ]);

        DB::table('categories')->insert([
            'name' => 'Marketing',
        ]);

    }
}
