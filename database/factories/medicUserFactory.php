<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\services;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MedicUser>
 */
class medicUserFactory extends Factory
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
            'specialty' => $this->faker->randomElement(['Cardiologo', 'Dermatologo', 'Neurologo', 'Pediatra']),
            'service_ID' => services::inRandomOrder()->first()->id,
        ];
    }
}
