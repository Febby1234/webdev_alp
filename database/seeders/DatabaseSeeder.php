<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🌱 Starting database seeding...');
        $this->command->newLine();

        $this->call([
            UserSeeder::class,
            MajorSeeder::class,
            BatchSeeder::class,
            RegistrationSeeder::class,
            AnnouncementSeeder::class,
            ScheduleSeeder::class,
        ]);

        $this->command->newLine();
        $this->command->info('✅ Database seeding completed successfully!');
        $this->command->newLine();
        $this->command->info('📧 Login credentials:');
        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['Admin', 'admin@example.com', 'password'],
                ['Admin 2', 'admin2@example.com', 'password'],
                ['Interviewer 1', 'interviewer1@example.com', 'password'],
                ['Interviewer 2', 'interviewer2@example.com', 'password'],
                ['Student', 'student@example.com', 'password'],
            ]
        );
        $this->command->newLine();
        $this->command->info('📊 Summary:');
        $this->command->info('- Users: 54 (2 admin, 2 interviewer, 50 students)');
        $this->command->info('- Majors: 6 (5 active, 1 inactive)');
        $this->command->info('- Batches: 4 (1 currently open)');
        $this->command->info('- Registrations: 30 (with complete data)');
        $this->command->info('- Announcements: 5');
        $this->command->info('- Schedules: 4 (2 exam, 2 interview)');
        $this->command->newLine();
    }
}
