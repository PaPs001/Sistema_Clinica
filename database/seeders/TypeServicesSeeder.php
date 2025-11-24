<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class TypeServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('services')->insert([
            ['name' => 'Cardiologia', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dermatologia', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Neurologia', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pediatria', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
