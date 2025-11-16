<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeder default
        $this->call([
            AdminSeeder::class,
            GuruSeeder::class,
            MuridSeeder::class,
            KelasSeeder::class,
            PembayaranSeeder::class,
        ]);
    }
}
