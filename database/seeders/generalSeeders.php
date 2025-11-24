<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class generalSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $this->call([
            documentTypeSeeder::class,
            AccesRolesSeeder::class,
            TypeServicesSeeder::class,
            UsersInitSeeder::class,
            appointmentSeeder::class,
            vitalSignsSeeder::class,
            allergieSeeder::class,
            diseaseSeeder::class,
        ]);
    }
}
