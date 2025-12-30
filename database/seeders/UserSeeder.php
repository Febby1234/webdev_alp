<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin Default
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => 12345678,
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Admin Secondary
        User::create([
            'name' => 'Admin Kedua',
            'email' => 'admin2@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Interviewer 1
        User::create([
            'name' => 'Dr. Budi Santoso',
            'email' => 'interviewer1@example.com',
            'password' => Hash::make('password'),
            'role' => 'interviewer',
            'email_verified_at' => now(),
        ]);

        // Interviewer 2
        User::create([
            'name' => 'Ir. Siti Nurhaliza',
            'email' => 'interviewer2@example.com',
            'password' => Hash::make('password'),
            'role' => 'interviewer',
            'email_verified_at' => now(),
        ]);

        // Student Demo
        User::create([
            'name' => 'Student Demo',
            'email' => 'student@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'email_verified_at' => now(),
        ]);

        // Generate 50 dummy students
        User::factory()
            ->count(50)
            ->student()
            ->create();

        $this->command->info('✅ Created 1 admin + 2 interviewers + 51 students');
    }
}
