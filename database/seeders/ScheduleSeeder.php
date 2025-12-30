<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;
use App\Models\Batch;
use Carbon\Carbon;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $batch = Batch::where('is_active', true)->first();

        $schedules = [
            [
                'batch_id' => $batch->id,
                'type' => 'exam',
                'date' => Carbon::now()->addDays(10),
                'time' => '08:00:00',
                'location' => 'Ruang Aula Lantai 2',
            ],
            [
                'batch_id' => $batch->id,
                'type' => 'exam',
                'date' => Carbon::now()->addDays(10),
                'time' => '13:00:00',
                'location' => 'Ruang Aula Lantai 2',
            ],
            [
                'batch_id' => $batch->id,
                'type' => 'interview',
                'date' => Carbon::now()->addDays(15),
                'time' => '08:00:00',
                'location' => 'Ruang Meeting Lantai 3',
            ],
            [
                'batch_id' => $batch->id,
                'type' => 'interview',
                'date' => Carbon::now()->addDays(15),
                'time' => '13:00:00',
                'location' => 'Ruang Meeting Lantai 3',
            ],
        ];

        foreach ($schedules as $schedule) {
            Schedule::create($schedule);
        }

        $this->command->info('✅ Created ' . count($schedules) . ' schedules');
    }
}
