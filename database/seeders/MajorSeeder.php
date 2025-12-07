<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Major;

class MajorSeeder extends Seeder
{
    public function run(): void
    {
        $majors = [
            ['name' => 'Rekayasa Perangkat Lunak', 'description' => 'Jurusan software development', 'quota' => 100, 'is_active' => true],
            ['name' => 'Teknik Komputer & Jaringan', 'description' => 'Jurusan jaringan komputer', 'quota' => 100, 'is_active' => true],
            ['name' => 'Akuntansi Keuangan Lembaga', 'description' => 'Jurusan akuntansi & keuangan', 'quota' => 80, 'is_active' => true],
            ['name' => 'Otomatisasi Tata Kelola Perkantoran', 'description' => 'Jurusan administrasi perkantoran', 'quota' => 80, 'is_active' => true],
        ];

        foreach ($majors as $major) {
            Major::create($major);
        }
    }
}
