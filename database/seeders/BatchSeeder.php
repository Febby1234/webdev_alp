<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Batch;

class BatchSeeder extends Seeder
{
    public function run(): void
    {
        Batch::create([
            'name' => 'Gelombang 1',
            'open_date' => now(),
            'close_date' => now()->addDays(30),
        ]);

        Batch::create([
            'name' => 'Gelombang 2',
            'open_date' => now()->addDays(31),
            'close_date' => now()->addDays(60),
        ]);
    }
}
