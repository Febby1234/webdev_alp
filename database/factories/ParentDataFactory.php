<?php

namespace Database\Factories;

use App\Models\Registration;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ParentData>
 */
class ParentDataFactory extends Factory
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
            'father_name' => fake()->name('male'),
            'father_job' => fake()->jobTitle(),
            'father_phone' => fake()->phoneNumber(),
            'mother_name' => fake()->name('female'),
            'mother_job' => fake()->jobTitle(),
            'mother_phone' => fake()->phoneNumber(),
            'guardian_name' => fake()->optional()->name(),
            'contact' => fake()->optional()->phoneNumber(),
        ];
    }
}
