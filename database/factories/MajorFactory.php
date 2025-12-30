<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Major>
 */
class MajorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                'Rekayasa Perangkat Lunak',
                'Teknik Komputer & Jaringan',
                'Akuntansi Keuangan Lembaga',
                'Otomatisasi Tata Kelola Perkantoran',
                'Bisnis Digital',
                'Multimedia',
            ]),
            'description' => fake()->paragraph(),
            'quota' => fake()->numberBetween(50, 150),
            'is_active' => true,
        ];
    }

    /**
     * Inactive major
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
