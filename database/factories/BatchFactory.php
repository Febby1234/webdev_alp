<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Batch>
 */
class BatchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('now', '+1 month');
        $endDate = fake()->dateTimeBetween($startDate, '+2 months');

        return [
            'name' => fake()->unique()->randomElement([
                'Gelombang 1',
                'Gelombang 2',
                'Gelombang 3',
                'Gelombang 4',
            ]),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_active' => true,
        ];
    }

    /**
     * Inactive batch
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Currently open batch
     */
    public function open(): static
    {
        return $this->state(fn (array $attributes) => [
            'start_date' => now()->subDays(5),
            'end_date' => now()->addDays(25),
            'is_active' => true,
        ]);
    }
}
