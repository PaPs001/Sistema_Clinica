<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use App\Models\userModel;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\userModel>
 */
class userModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = userModel::class;
    
    public function definition(): array
    {
        return [
            //
            'name' => fake()->Name(),
            'birthdate' => fake()->date(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'password' => '12345',
            'address' => fake()->address(),
            'status' => 'active',
            'typeUser_id' => rand(1,5),
        ];
    }
}
