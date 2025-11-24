<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class documentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('document_types')->insert([
            ['name' => 'Radiografia', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Analisis de laboratorio', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ecografia', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tomografia', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Resonancia Magnetica', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Receta medica', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'otros', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
