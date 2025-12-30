<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Major;
use App\Models\Batch;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Registration>
 */
class RegistrationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'major_id' => Major::inRandomOrder()->first()?->id ?? Major::factory(),
            'batch_id' => Batch::inRandomOrder()->first()?->id ?? Batch::factory(),
            'status' => fake()->randomElement([
                'pending',
                'documents_pending',
                'documents_verified',
                'payment_pending',
                'paid',
                'exam_scheduled',
                'interview_scheduled',
                'finished',
                'accepted',
                'rejected'
            ]),
        ];
    }

    /**
     * Status: pending
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    /**
     * Status: accepted
     */
    public function accepted(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'accepted',
        ]);
    }

    /**
     * Status: rejected
     */
    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rejected',
        ]);
    }

    /**
     * Status: paid (ready for exam)
     */
    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'paid',
        ]);
    }
}
