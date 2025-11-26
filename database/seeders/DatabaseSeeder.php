<?php

namespace Database\Seeders;

use Database\Seeders\AccesRolesSeeder;
use Database\Seeders\ActionSeeder;
use Database\Seeders\allergieSeeder;
use Database\Seeders\appointmentSeeder;
use Database\Seeders\diseaseSeeder;
use Database\Seeders\documentTypeSeeder;
use Database\Seeders\generalSeeders;
use Database\Seeders\initPermissionsSeeders;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\TypeServicesSeeder;
// ...
use Database\Seeders\UsersInitSeeder;
use Database\Seeders\vitalSignsSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AccesRolesSeeder::class,
            ActionSeeder::class,
            allergieSeeder::class,
            appointmentSeeder::class,
            diseaseSeeder::class,
            documentTypeSeeder::class,
            generalSeeders::class,
            initPermissionsSeeders::class,
            PermissionSeeder::class,
            RolePermissionSeeder::class,
            TypeServicesSeeder::class,
            UsersInitSeeder::class,
            vitalSignsSeeder::class,
        ]);
    }
}
