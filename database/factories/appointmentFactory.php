<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\patientUser;
use App\Models\medicUser;
use App\Models\receptionistUser;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\appointment>
 */
class appointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $doctor = medicUser::inRandomOrder()->first();
        return [
            //
            'patient_id' => patientUser::where('is_Temporary', true)->inRandomOrder()->first()?->id ?? 1,
            'doctor_id' => $doctor->id,
            'services_id' => $doctor->service_ID,
            'receptionist_id' => receptionistUser::inRandomOrder()->first()?->id ?? 1,
            'appointment_date' => $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'appointment_time' => $this->faker->time('H:i'),
            'status' => 'agendada',
            'reason' => $this->faker->sentence(10),
            'notes' => $this->faker->text(200),
            'notifications' => null,
        ];
    }
}
