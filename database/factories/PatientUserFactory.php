<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PatientUser>
 */
class patientUserFactory extends Factory
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
            'userId' => null,
            'DNI' => $this->faker->unique()->numerify('##########'),
            'is_Temporary' => false,
            'temporary_name' => null,
            'temporary_phone' => null,
        ];
    }

    public function temporaryData(){
        return $this->state(function (array $attributes){
            return[
                'userId' => null,
                'DNI' => $this->faker->unique()->numerify('##########'),
                'is_Temporary' => true,
                'temporary_name' => $this->faker->name(),
                'temporary_phone' => $this->faker->phoneNumber(),
            ];
        });
    }
}
