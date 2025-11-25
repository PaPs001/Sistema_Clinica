<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permissions;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $permissions = [
            'crear_usuarios',
            'ver_expedientes',
            'crear_notas',
            'editar_notas',
            'ver_pacientes',
            'crear_citas',
            'editar_citas',
            'ver_su_expediente',


            'ver_reportes',
            'administrar_roles',
            'asignar_permisos',
            'eliminar_usuarios',
            'ver_usuarios',
            'editar_usuarios',
            'crear_expedientes',
            'editar_expedientes',
            'descargar_reportes',
            'descargar_archivos',
            'subir_archivos',
            'crear_reportes'
        ];

        foreach ($permissions as $p) {
            Permissions::firstOrCreate(['name_permission' => $p]);
        }
    }
}
