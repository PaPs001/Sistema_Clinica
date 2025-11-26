<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\appointment;
use App\Models\patientUser;
use App\Models\medicUser;
use App\Models\receptionistUser;
use Carbon\Carbon;

class appointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = patientUser::where('is_Temporary', false)->get();
        $doctors = medicUser::all();
        $receptionists = receptionistUser::all();

        if ($patients->count() === 0 || $doctors->count() === 0 || $receptionists->count() === 0) {
            return;
        }

        /**
         * 1) Garantizar que TODOS los pacientes NO temporales
         *    tengan al menos UNA cita completada.
         */
        foreach ($patients as $patient) {
            $doctor = $doctors->random();
            $receptionist = $receptionists->random();

            $date = Carbon::now()->subDays(rand(1, 15))->toDateString(); // fechas pasadas
            $time = sprintf('%02d:%02d', rand(8, 18), rand(0, 1) ? 0 : 30);

            appointment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'services_id' => $doctor->service_ID,
                'receptionist_id' => $receptionist->id,
                'appointment_date' => $date,
                'appointment_time' => $time,
                'status' => 'completada',
                'reason' => 'Consulta completada generada por seeder',
                'notes' => 'Notas de consulta completada para este paciente.',
                'notifications' => null,
            ]);
        }

        /**
         * 2) Citas adicionales para cubrir otros estatus.
         *    Se generan 5 por cada estatus distinto de "completada".
         */
        $extraStatuses = [
            'agendada',
            'En curso',
            'cancelada',
            'Sin confirmar',
            'Confirmada',
        ];

        $scheduledPairs = []; // para evitar dos 'agendada' mismo paciente/médico

        foreach ($extraStatuses as $status) {
            for ($i = 0; $i < 5; $i++) {
                $patient = $patients->random();
                $doctor = $doctors->random();

                if ($status === 'agendada') {
                    $attempts = 0;
                    while ($attempts < 10) {
                        $pairKey = $patient->id . '-' . $doctor->id;
                        if (!isset($scheduledPairs[$pairKey])) {
                            $scheduledPairs[$pairKey] = true;
                            break;
                        }

                        $patient = $patients->random();
                        $doctor = $doctors->random();
                        $pairKey = $patient->id . '-' . $doctor->id;
                        $attempts++;
                    }
                }

                $receptionist = $receptionists->random();

                $date = Carbon::now()->addDays(rand(-15, 30))->toDateString();
                $time = sprintf('%02d:%02d', rand(8, 18), rand(0, 1) ? 0 : 30);

                appointment::create([
                    'patient_id' => $patient->id,
                    'doctor_id' => $doctor->id,
                    'services_id' => $doctor->service_ID,
                    'receptionist_id' => $receptionist->id,
                    'appointment_date' => $date,
                    'appointment_time' => $time,
                    'status' => $status,
                    'reason' => 'Consulta generada por seeder',
                    'notes' => 'Notas automáticas de prueba para la cita.',
                    'notifications' => null,
                ]);
            }
        }
    }
}
