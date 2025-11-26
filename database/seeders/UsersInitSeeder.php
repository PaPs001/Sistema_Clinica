<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\UserModel;
use App\Models\administratorUser;
use App\Models\medicUser;
use App\Models\patientUser;
use App\Models\receptionistUser;
use App\Models\nurseUser;

class UsersInitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ============================
        // 🔐  ADMINISTRADOR FIJO
        // ============================
        $admin = new UserModel();
        $admin->name        = 'Admin Principal';
        $admin->email       = 'admin@clinicapp.test';
        $admin->password    = Hash::make('admin123');
        $admin->typeUser_id = 1;                // administrador
        $admin->birthdate   = '1990-01-01';
        $admin->phone       = '5550000001';
        $admin->address     = 'Dirección Admin 123';
        $admin->genre       = 'hombre';         // 👈 obligatorio en general_users
        // $admin->status   = 'active';         // opcional, tiene default 'inactive'
        $admin->save();

        administratorUser::create([
            'userId' => $admin->id,
        ]);


        // ============================
        // 🛎️  RECEPCIONISTA FIJO
        // ============================
        $recep = new UserModel();
        $recep->name        = 'Recepcionista Demo';
        $recep->email       = 'recepcion@clinicapp.test';
        $recep->password    = Hash::make('recep123');
        $recep->typeUser_id = 4;                // recepcionista
        $recep->birthdate   = '1995-05-10';
        $recep->phone       = '5550000002';
        $recep->address     = 'Recepción Clínica 1';
        $recep->genre       = 'hombre';
        $recep->save();

        receptionistUser::create([
            'userId' => $recep->id,
            'turno'  => 'matutino',             // 👈 obligatorio en recepcionist_users
        ]);


        // ============================
        // 🩺  ENFERMERA FIJA
        // ============================
        $nurse = new UserModel();
        $nurse->name        = 'Enfermera Demo';
        $nurse->email       = 'nurse@clinicapp.test';
        $nurse->password    = Hash::make('nurse123');
        $nurse->typeUser_id = 5;                // enfermera
        $nurse->birthdate   = '1993-08-20';
        $nurse->phone       = '5550000003';
        $nurse->address     = 'Área de Enfermería';
        $nurse->genre       = 'mujer';
        $nurse->save();

        nurseUser::create([
            'userId' => $nurse->id,
            'turno'  => 'matutino',             // 👈 obligatorio en nurse_users
        ]);


        // ============================
        // 👤  PACIENTE FIJO
        // ============================
        $patient = new UserModel();
        $patient->name        = 'Paciente Demo';
        $patient->email       = 'paciente@clinicapp.test';
        $patient->password    = Hash::make('paciente123');
        $patient->typeUser_id = 3;              // paciente
        $patient->birthdate   = '2000-12-15';
        $patient->phone       = '5550000004';
        $patient->address     = 'Calle Paciente 45';
        $patient->genre       = 'hombre';
        $patient->save();

        patientUser::create([
            'userId' => $patient->id,
            'DNI'    => 'PAC-0001',             // obligatorio en patient_users
        ]);


        // ============================
        // 👥  USUARIOS POR TIPO (FACTORY)
        // ============================
        $types = [1, 2, 3, 4, 5];

        foreach ($types as $type) {
            $user = UserModel::factory()->create(['typeUser_id' => $type]);

            switch ($type) {
                case 1:
                    administratorUser::factory()->create(['userId' => $user->id]);
                    break;
                case 2:
                    medicUser::factory()->create(['userId' => $user->id]);
                    break;
                case 3:
                    patientUser::factory()->create(['userId' => $user->id]);
                    break;
                case 4:
                    receptionistUser::factory()->create(['userId' => $user->id]);
                    break;
                case 5:
                    nurseUser::factory()->create(['userId' => $user->id]);
                    break;
            }
        }

        // ============================
        // 👥  USUARIOS EXTRA RANDOM
        // ============================
        UserModel::factory()->count(5)->create()->each(function ($user) {
            $typeUserId = $user->typeUser_id;

            switch ($typeUserId) {
                case 1:
                    administratorUser::factory()->create(['userId' => $user->id]);
                    break;
                case 2:
                    medicUser::factory()->create(['userId' => $user->id]);
                    break;
                case 3:
                    patientUser::factory()->create(['userId' => $user->id]);
                    break;
                case 4:
                    receptionistUser::factory()->create(['userId' => $user->id]);
                    break;
                case 5:
                    nurseUser::factory()->create(['userId' => $user->id]);
                    break;
            }
        });

        // ============================
        // 🧪 PACIENTES TEMPORALES EXTRA
        // ============================
        patientUser::factory()->count(5)->temporaryData()->create();
    }
}