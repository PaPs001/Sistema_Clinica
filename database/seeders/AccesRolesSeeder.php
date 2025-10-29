<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccesRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('acces_roles')->insert([
            ['id' => 1, 'name_type' => 'admin'],
            ['id' => 2, 'name_type' => 'medico'],
            ['id' => 3, 'name_type' => 'paciente'],
            ['id' => 4, 'name_type' => 'recepcionista'],
            ['id' => 5, 'name_type' => 'enfermera'],
        ]);
    }
}
