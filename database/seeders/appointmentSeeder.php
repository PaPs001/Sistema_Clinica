<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\appointment;
use App\Models\patientUser;

class appointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $temporaryPatients = patientUser::where('is_Temporary', true)->get();
        
        foreach ($temporaryPatients as $patient){
            appointment::factory()
                ->count(rand(1, 3))
                ->create([
                    'patient_id' => $patient->id,
                ]);
        }
    }
}
