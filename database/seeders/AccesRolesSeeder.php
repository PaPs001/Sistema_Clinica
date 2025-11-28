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
        $roles = [
            1 => 'admin',
            2 => 'medico',
            3 => 'paciente',
            4 => 'recepcionista',
            5 => 'enfermera',
        ];

        foreach ($roles as $id => $name) {
            DB::table('acces_roles')->updateOrInsert(
                ['id' => $id],
                ['name_type' => $name]
            );
        }
    }
}
