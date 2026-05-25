<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
//            RuLangSeeder::class,
//            FamilyClubSeeder::class,
//            ProgressStageSeeder::class,
//            ProgressStageSeeder2::class,
            KkFcSeeder::class,
            KkLangSeeder::class,
            KkLangSeeder2::class,
            KkPsSeeder::class
        ]);
    }
}
