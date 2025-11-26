<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeders base existentes
        if (class_exists(generalSeeders::class)) {
            $this->call(generalSeeders::class);
        }

        // Datos demo para enfermería
        if (class_exists(EnfermeraDemoSeeder::class)) {
            $this->call(EnfermeraDemoSeeder::class);
        }
    }
}
