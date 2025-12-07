<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Default
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Interviewer Default
        User::create([
            'name' => 'Interviewer Satu',
            'email' => 'interviewer@example.com',
            'password' => Hash::make('password'),
            'role' => 'interviewer',
        ]);

        // Student Dummy
        User::create([
            'name' => 'Student Demo',
            'email' => 'student@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);
    }
}