<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\vital_sign;
use App\Models\appointment;
use App\Models\nurseUser;
use App\Models\patientUser;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class vital_signFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'patient_id' => patientUser::inRandomOrder()->first()?->id ?? 1,
            'register_date'=> appointment::inRandomOrder()->first()?->id ?? 1,
            'temperature' => $this->faker->randomFloat(1, 35, 40),
            'heart_rate' => $this->faker->numberBetween(60, 160),
            'weight' => $this->faker->numberBetween(10, 150),
            'height' => $this->faker->numberBetween(50, 200),
            'register_by' => nurseUser::inRandomOrder()->first()?->id ?? 1,
        ];
    }
}
