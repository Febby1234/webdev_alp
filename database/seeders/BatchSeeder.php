<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Batch;
use Carbon\Carbon;

class BatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $batches = [
            [
                'batch_name' => 'Gelombang 1',
                'start_date' => Carbon::now()->subDays(30),
                'end_date' => Carbon::now()->addDays(30),
                'is_active' => true, // Currently open
            ],
            [
                'batch_name' => 'Gelombang 2',
                'start_date' => Carbon::now()->addDays(31),
                'end_date' => Carbon::now()->addDays(90),
                'is_active' => true, // Will open soon
            ],
            [
                'batch_name' => 'Gelombang 3',
                'start_date' => Carbon::now()->addDays(91),
                'end_date' => Carbon::now()->addDays(150),
                'is_active' => true, // Will open later
            ],
            [
                'batch_name' => 'Gelombang 4',
                'start_date' => Carbon::now()->addDays(151),
                'end_date' => Carbon::now()->addDays(210),
                'is_active' => false, // Not active yet
            ],
        ];

        foreach ($batches as $batch) {
            Batch::create($batch);
        }

        $this->command->info('✅ Created ' . count($batches) . ' batches');
    }
}
