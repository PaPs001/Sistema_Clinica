<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccesRolesSeeder extends Seeder
{
    public function run(): void
    {
        // Opcional si alguna vez corres solo db:seed
        // DB::table('acces_roles')->truncate();

        $roles = [
            'admin',
            'medico',
            'paciente',
            'recepcionista',
            'enfermera',
        ];

        foreach ($roles as $role) {
            DB::table('acces_roles')->updateOrInsert(
                ['name_type' => $role], // condición única
                []                      // no actualizamos otros campos
            );
        }
    }
}
