<?php

namespace Database\Factories;

use App\Models\Registration;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PersonalDetail>
 */
class PersonalDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'registration_id' => Registration::factory(),
            'full_name' => fake()->name(),
            'birth_place' => fake()->city(),
            'birth_date' => fake()->dateTimeBetween('-20 years', '-15 years')->format('Y-m-d'),
            'gender' => fake()->randomElement(['Laki-laki', 'Perempuan']),
            'address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
        ];
    }
}
