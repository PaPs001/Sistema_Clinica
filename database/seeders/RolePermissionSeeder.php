<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\roleModel;
use App\Models\Permissions;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $roles = [
            'admin' => [
                'crear_usuarios',
                'crear_usuarios',
                'ver_pacientes',
                'ver_reportes',
                'administrar_roles',
                'asignar_permisos',
                'eliminar_usuarios',
                'ver_usuarios',
                'editar_usuarios',
                'crear_reportes',
                'descargar_reportes',
            ],

            'medico' => [
                'ver_expedientes',
                'crear_notas',
                'editar_notas',
                'ver_pacientes',
                'ver_su_expediente',
                'crear_expedientes',
                'editar_expedientes',
                'descargar_archivos',
                'subir_archivos',
            ],

            'recepcionista' => [
                'ver_pacientes',
                'crear_citas',
                'editar_citas'
            ],

            'paciente' => [
                'ver_su_expediente',
                'descargar_archivos'
            ],

            'enfermera' => [
                'ver_expedientes',
                'crear_notas',
                'editar_notas',
                'ver_pacientes',
                'editar_expedientes',
            ],
        ];

        foreach ($roles as $roleName => $permissions) {

            $role = roleModel::where('name_type', $roleName)->first();

            foreach ($permissions as $perm) {
                $permission = Permissions::where('name_permission', $perm)->first();

                $role->permissions()->syncWithoutDetaching([$permission->id]);
            }
        }
    }
}
