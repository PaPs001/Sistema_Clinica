<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\userModel;
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
        //
        $types = [1,2,3,4,5];
        foreach($types as $type){
            $user = userModel::factory()->create(['typeUser_id' => $type]);

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

        userModel::factory()->count(5)->create()->each(function ($user) {
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
    }
}
