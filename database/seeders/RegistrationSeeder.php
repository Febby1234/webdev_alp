<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Major;
use App\Models\Batch;
use App\Models\Registration;
use App\Models\PersonalDetail;
use App\Models\ParentData;
use App\Models\SchoolOrigin;

class RegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get students (skip first one as it's demo account)
        $students = User::where('role', 'student')->skip(1)->take(30)->get();
        $majors = Major::where('is_active', true)->get();
        $batch = Batch::where('is_active', true)->first();

        foreach ($students as $student) {
            // Create registration
            $registration = Registration::create([
                'user_id' => $student->id,
                'major_id' => $majors->random()->id,
                'batch_id' => $batch->id,
                'status' => fake()->randomElement([
                    'pending',
                    'documents_pending',
                    'documents_verified',
                    'payment_pending',
                    'paid',
                    'exam_scheduled',
                    'finished',
                    'accepted',
                    'rejected'
                ]),
            ]);

            // Create personal detail
            PersonalDetail::create([
                'registration_id' => $registration->id,
                'full_name' => $student->name,
                'birth_place' => fake()->city(),
                'birth_date' => fake()->dateTimeBetween('-20 years', '-15 years'),
                'gender' => fake()->randomElement(['Laki-laki', 'Perempuan']),
                'address' => fake()->address(),
                'phone' => fake()->phoneNumber(),
            ]);

            // Create parent data
            ParentData::create([
                'registration_id' => $registration->id,
                'father_name' => fake()->name('male'),
                'father_job' => fake()->jobTitle(),
                'father_phone' => fake()->phoneNumber(),
                'mother_name' => fake()->name('female'),
                'mother_job' => fake()->jobTitle(),
                'mother_phone' => fake()->phoneNumber(),
            ]);

            // Create school origin
            SchoolOrigin::create([
                'registration_id' => $registration->id,
                'school_origin_name' => fake()->randomElement([
                    'SMA Negeri 1 Jakarta',
                    'SMA Negeri 2 Jakarta',
                    'SMK Negeri 1 Jakarta',
                    'SMA Swasta Plus',
                    'SMK Teknologi Nusantara',
                ]),
                'graduation_year' => fake()->numberBetween(2022, 2024),
                'average_grade' => fake()->randomFloat(2, 70, 95),
            ]);
        }

        $this->command->info('✅ Created 30 registrations with complete data');
    }
}
