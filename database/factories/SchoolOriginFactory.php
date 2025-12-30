<?php

namespace Database\Factories;

use App\Models\Registration;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SchoolOrigin>
 */
class SchoolOriginFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $schools = [
            'SMA Negeri 1 Jakarta',
            'SMA Negeri 2 Jakarta',
            'SMA Negeri 3 Jakarta',
            'SMK Negeri 1 Jakarta',
            'SMK Negeri 2 Jakarta',
            'SMA Swasta Plus',
            'SMK Teknologi Nusantara',
            'SMA Al-Azhar',
            'SMK Pembangunan',
            'SMA Katolik Santa Maria',
        ];

        return [
            'registration_id' => Registration::factory(),
            'school_origin_name' => fake()->randomElement($schools),
            'graduation_year' => fake()->numberBetween(2022, 2024),
            'average_grade' => fake()->randomFloat(2, 70, 95),
        ];
    }
}
