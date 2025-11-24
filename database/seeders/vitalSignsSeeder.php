<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\appointment;
use App\Models\vital_sign;

class vitalSignsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $appointments = appointment::all();

        foreach ($appointments as $appointment){
            vital_sign::factory()->create([
                'patient_id' => $appointment->patient_id,
                'register_date' => $appointment->id,
            ]);
        }
    }
}
