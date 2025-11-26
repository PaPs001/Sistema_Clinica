<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\patientUser;
use App\Models\medical_records;
use App\Models\disease;
use App\Models\diseaseRecord;
use App\Models\allergie;
use App\Models\allergene;
use App\Models\allergies_allergenes;
use App\Models\allergyRecord;
use App\Models\appointment;
use App\Models\consult_disease;
use App\Models\MedicPatient;
use Faker\Factory as FakerFactory;

class MedicalRecordsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = FakerFactory::create();

        $allDiseases = disease::all();
        $allAllergies = allergie::all();
        $allAllergenes = allergene::all();

        // Solo pacientes con citas completadas
        $completedAppointments = appointment::where('status', 'completada')
            ->get()
            ->groupBy('patient_id');

        if ($completedAppointments->isEmpty()) {
            return;
        }

        foreach ($completedAppointments as $patientId => $appointmentsForPatient) {
            if (!$patientId) {
                continue;
            }

            $patient = patientUser::find($patientId);
            if (!$patient) {
                continue;
            }

            // Un expediente por paciente con citas completadas
            $record = medical_records::firstOrCreate(
                ['patient_id' => $patient->id],
                ['creation_date' => now()]
            );

            // Enfermedades crónicas asociadas al expediente
            if ($allDiseases->isNotEmpty()) {
                $diseasesForRecord = $allDiseases->random(min(3, $allDiseases->count()));

                foreach ($diseasesForRecord as $dis) {
                    diseaseRecord::create([
                        'id_record' => $record->id,
                        'chronics_diseases_id' => $dis->id,
                        'notes' => $faker->sentence(10),
                    ]);
                }
            }

            // Alergias / alergenos en el expediente
            if ($allAllergies->isNotEmpty() && $allAllergenes->isNotEmpty()) {
                $allergy = $allAllergies->random();
                $allergene = $allAllergenes->random();

                $allergieAllergene = allergies_allergenes::firstOrCreate([
                    'allergie_id' => $allergy->id,
                    'allergene_id' => $allergene->id,
                ]);

                allergyRecord::create([
                    'id_record' => $record->id,
                    'allergie_allergene_id' => $allergieAllergene->id,
                    'severity' => $faker->randomElement(['Leve', 'Moderada', 'Grave']),
                    'status' => $faker->randomElement(['Activa', 'Inactiva']),
                    'symptoms' => $faker->sentence(8),
                    'treatments' => $faker->sentence(8),
                    'diagnosis_date' => $faker->date(),
                    'notes' => $faker->sentence(10),
                ]);
            }

            // Una consulta (consult_disease) por cada cita completada de este paciente
            foreach ($appointmentsForPatient as $appointment) {
                $diagnosis = $allDiseases->isNotEmpty()
                    ? $allDiseases->random()
                    : null;

                // Relación médico-paciente para esta consulta completada
                if ($appointment->doctor_id) {
                    MedicPatient::firstOrCreate([
                        'medic_id' => $appointment->doctor_id,
                        'patient_id' => $patient->id,
                    ]);
                }

                consult_disease::create([
                    'id_medical_record' => $record->id,
                    'appointment_id' => $appointment->id,
                    'reason' => $appointment->reason,
                    'symptoms' => $faker->sentence(8),
                    'findings' => $faker->sentence(10),
                    'diagnosis_id' => $diagnosis?->id ?? ($allDiseases->first()->id ?? 1),
                    'treatment_diagnosis' => $faker->sentence(10),
                ]);
            }
        }
    }
}
