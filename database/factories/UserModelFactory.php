<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use App\Models\UserModel;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\userModel>
 */
class UserModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = UserModel::class;
    
    public function definition(): array
    {
        return [
            //
            'name' => fake()->name(),
            'birthdate' => fake()->date(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'password' => '12345',
            'address' => fake()->address(),
            'status' => 'active',
            'genre' => $this->faker->randomElement(['hombre', 'mujer']),
            'typeUser_id' => rand(1,5),
        ];
    }
}
