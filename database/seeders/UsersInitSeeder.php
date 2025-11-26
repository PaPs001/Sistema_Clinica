<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserModel;
use App\Models\administratorUser;
use App\Models\medicUser;
use App\Models\patientUser;
use App\Models\receptionistUser;
use App\Models\nurseUser;

class UsersInitSeeder extends Seeder
{
    /**
     * Run the dataabase seeds.
     */
    public function run(): void
    {
        $staticUsers = [
            [
                'typeUser_id' => 1,
                'email' => 'admin@example.test',
                'password' => '12345',
                'name' => 'Admin Demo',
            ],
            [
                'typeUser_id' => 2,
                'email' => 'medic@example.test',
                'password' => '12345',
                'name' => 'Médico Demo',
            ],
            [
                'typeUser_id' => 3,
                'email' => 'patient@example.test',
                'password' => '12345',
                'name' => 'Paciente Demo',
            ],
            [
                'typeUser_id' => 4,
                'email' => 'receptionist@example.test',
                'password' => '12345',
                'name' => 'Recepcionista Demo',
            ],
            [
                'typeUser_id' => 5,
                'email' => 'nurse@example.test',
                'password' => '12345',
                'name' => 'Enfermera Demo',
            ],
        ];

        foreach ($staticUsers as $data) {
            $user = UserModel::factory()->create([
                'typeUser_id' => $data['typeUser_id'],
                'email' => $data['email'],
                'password' => $data['password'],
                'name' => $data['name'],
            ]);

            switch ($data['typeUser_id']) {
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

        $targets = [
            1 => 2,  // administradores
            2 => 7,  // médicos
            3 => 15, // pacientes
            4 => 4,  // recepcionistas
            5 => 5,  // enfermeras
        ];

        foreach ($targets as $typeUserId => $targetTotal) {
            $extraToCreate = max(0, $targetTotal - 1);

            for ($i = 0; $i < $extraToCreate; $i++) {
                $user = UserModel::factory()->create([
                    'typeUser_id' => $typeUserId,
                ]);

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
            }
        }

        patientUser::factory()->count(5)->temporaryData()->create();
    }
}
