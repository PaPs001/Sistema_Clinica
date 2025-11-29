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

        // Catálogo de medicamentos desde CSV
        if (class_exists(MedicationSeeder::class)) {
            $this->call(MedicationSeeder::class);
        }
    }
}
