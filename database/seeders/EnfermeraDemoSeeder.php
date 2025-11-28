<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EnfermeraDemoSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Roles básicos
        $roles = [
            'enfermera',
            'medico',
            'paciente',
        ];
        $roleIds = [];
        foreach ($roles as $name) {
            $roleIds[$name] = DB::table('acces_roles')->updateOrInsert(
                ['name_type' => $name],
                ['created_at' => now(), 'updated_at' => now()]
            ) ?: DB::table('acces_roles')->where('name_type', $name)->value('id');
            if (!$roleIds[$name]) {
                $roleIds[$name] = DB::table('acces_roles')->where('name_type', $name)->value('id');
            }
        }

        // Servicios
        $services = [
            'UCI',
            'Medicina',
            'Cirugía',
        ];
        $serviceIds = [];
        foreach ($services as $service) {
            $id = DB::table('services')->updateOrInsert(
                ['name' => $service],
                ['created_at' => now(), 'updated_at' => now()]
            ) ?: DB::table('services')->where('name', $service)->value('id');
            $serviceIds[$service] = $id ?: DB::table('services')->where('name', $service)->value('id');
        }

        // General users
        $general = [
            'nurse' => [
                'name' => 'Laura Martínez',
                'birthdate' => '1990-05-10',
                'phone' => '555-1000',
                'email' => 'laura@nurse.com',
                'password' => Hash::make('password'),
                'address' => 'Hospital Naval',
                'genre' => 'mujer',
                'status' => 'active',
                'typeUser_id' => $roleIds['enfermera'],
            ],
            'medico' => [
                'name' => 'Dr. Carlos Ruiz',
                'birthdate' => '1980-03-15',
                'phone' => '555-2000',
                'email' => 'carlos@medic.com',
                'password' => Hash::make('password'),
                'address' => 'Hospital Naval',
                'genre' => 'hombre',
                'status' => 'active',
                'typeUser_id' => $roleIds['medico'],
            ],
            'p1' => [
                'name' => 'Carlos Ruiz',
                'birthdate' => '1960-01-01',
                'phone' => '555-3000',
                'email' => 'paciente1@example.com',
                'password' => Hash::make('password'),
                'address' => 'Ciudad',
                'genre' => 'hombre',
                'status' => 'active',
                'typeUser_id' => $roleIds['paciente'],
            ],
            'p2' => [
                'name' => 'Ana López',
                'birthdate' => '1983-06-20',
                'phone' => '555-3001',
                'email' => 'paciente2@example.com',
                'password' => Hash::make('password'),
                'address' => 'Ciudad',
                'genre' => 'mujer',
                'status' => 'active',
                'typeUser_id' => $roleIds['paciente'],
            ],
            'p3' => [
                'name' => 'Miguel Torres',
                'birthdate' => '1970-09-12',
                'phone' => '555-3002',
                'email' => 'paciente3@example.com',
                'password' => Hash::make('password'),
                'address' => 'Ciudad',
                'genre' => 'hombre',
                'status' => 'active',
                'typeUser_id' => $roleIds['paciente'],
            ],
        ];

        $generalIds = [];
        foreach ($general as $key => $data) {
            $id = DB::table('general_users')->updateOrInsert(
                ['email' => $data['email']],
                $data + ['created_at' => now(), 'updated_at' => now()]
            ) ?: DB::table('general_users')->where('email', $data['email'])->value('id');
            $generalIds[$key] = $id ?: DB::table('general_users')->where('email', $data['email'])->value('id');
        }

        // Nurse
        $nurseId = DB::table('nurse_users')->updateOrInsert(
            ['userId' => $generalIds['nurse']],
            ['turno' => 'matutino', 'created_at' => now(), 'updated_at' => now()]
        ) ?: DB::table('nurse_users')->where('userId', $generalIds['nurse'])->value('id');
        if (!$nurseId) {
            $nurseId = DB::table('nurse_users')->where('userId', $generalIds['nurse'])->value('id');
        }

        // Medic
        $medicId = DB::table('medic_users')->updateOrInsert(
            ['userId' => $generalIds['medico']],
            [
                'specialty' => 'Medicina Interna',
                'service_ID' => $serviceIds['Medicina'] ?? $serviceIds['UCI'],
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ) ?: DB::table('medic_users')->where('userId', $generalIds['medico'])->value('id');
        if (!$medicId) {
            $medicId = DB::table('medic_users')->where('userId', $generalIds['medico'])->value('id');
        }

        // Patients
        $patientsData = [
            ['general' => 'p1', 'DNI' => '12345678A', 'room' => '304 - UCI'],
            ['general' => 'p2', 'DNI' => '23456789B', 'room' => '205 - Medicina'],
            ['general' => 'p3', 'DNI' => '34567890C', 'room' => '102 - Cirugía'],
        ];
        $patientIds = [];
        foreach ($patientsData as $pd) {
            $id = DB::table('patient_users')->updateOrInsert(
                ['userId' => $generalIds[$pd['general']]],
                [
                    'DNI' => $pd['DNI'],
                    'is_Temporary' => false,
                    'userCode' => Str::upper(Str::random(6)),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ) ?: DB::table('patient_users')->where('userId', $generalIds[$pd['general']])->value('id');
            $patientIds[$pd['general']] = $id ?: DB::table('patient_users')->where('userId', $generalIds[$pd['general']])->value('id');
        }

        // Appointments (para registrar signos)
        $appointments = [];
        foreach ($patientIds as $key => $pid) {
            $appointments[$key] = DB::table('appointments')->insertGetId([
                'patient_id' => $pid,
                'doctor_id' => $medicId,
                'receptionist_id' => null,
                'services_id' => $serviceIds['Medicina'] ?? $serviceIds['UCI'],
                'appointment_date' => now()->toDateString(),
                'appointment_time' => now()->format('H:i:s'),
                'status' => 'Confirmada',
                'reason' => 'Control',
                'notes' => 'Control de rutina',
                'notifications' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Signos vitales
        DB::table('vital_signs')->insert([
            [
                'patient_id' => $patientIds['p1'],
                'register_date' => $appointments['p1'],
                'temperature' => 37.2,
                'heart_rate' => 92,
                'weight' => 70,
                'height' => 170,
                'register_by' => $nurseId,
                'blood_pressure' => '180/110',
                'respiratory_rate' => 20,
                'oxygen_saturation' => 96,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'patient_id' => $patientIds['p2'],
                'register_date' => $appointments['p2'],
                'temperature' => 39.2,
                'heart_rate' => 88,
                'weight' => 65,
                'height' => 165,
                'register_by' => $nurseId,
                'blood_pressure' => '130/85',
                'respiratory_rate' => 18,
                'oxygen_saturation' => 95,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Medicamentos
        DB::table('medications')->insertOrIgnore([
            [
                'name' => 'Amoxicilina',
                'category' => 'Antibiótico',
                'presentation' => 'Cápsulas',
                'concentration' => '500mg',
                'stock' => 180,
                'min_stock' => 50,
                'expiration_date' => now()->addYears(1)->toDateString(),
                'batch_number' => 'Lote-AMX-001',
                'provider' => 'Farmasias del bienestar',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Paracetamol',
                'category' => 'Analgésico',
                'presentation' => 'Tabletas',
                'concentration' => '500mg',
                'stock' => 250,
                'min_stock' => 80,
                'expiration_date' => now()->addMonths(10)->toDateString(),
                'batch_number' => 'Lote-PCT-010',
                'provider' => 'Genéricos MX',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
