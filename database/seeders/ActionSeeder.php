<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Actions;

class ActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $actions = [
            ['name_action' => 'add', 'description_action' => 'Agregar permiso'],
            ['name_action' => 'delete', 'description_action' => 'Eliminar permiso'],
        ];
        foreach ($actions as $action) {
            Actions::firstOrCreate($action);
        }
    }
}
