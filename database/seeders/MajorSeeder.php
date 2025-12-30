<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Major;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $majors = [
            [
                'name' => 'Rekayasa Perangkat Lunak',
                'description' => 'Program keahlian yang mempelajari pengembangan software, pemrograman, database, dan teknologi web. Lulusan diharapkan mampu mengembangkan aplikasi desktop, web, dan mobile.',
                'quota' => 100,
                'is_active' => true
            ],
            [
                'name' => 'Teknik Komputer & Jaringan',
                'description' => 'Program keahlian yang mempelajari instalasi, konfigurasi, dan maintenance jaringan komputer, server, dan infrastruktur IT. Lulusan diharapkan mampu mengelola jaringan komputer.',
                'quota' => 100,
                'is_active' => true
            ],
            [
                'name' => 'Akuntansi Keuangan Lembaga',
                'description' => 'Program keahlian yang mempelajari pencatatan keuangan, pembukuan, perpajakan, dan audit. Lulusan diharapkan mampu mengelola keuangan perusahaan atau lembaga.',
                'quota' => 80,
                'is_active' => true
            ],
            [
                'name' => 'Otomatisasi Tata Kelola Perkantoran',
                'description' => 'Program keahlian yang mempelajari administrasi perkantoran, kearsipan, korespondensi, dan manajemen kantor. Lulusan diharapkan mampu mengelola administrasi perkantoran modern.',
                'quota' => 80,
                'is_active' => true
            ],
            [
                'name' => 'Bisnis Digital',
                'description' => 'Program keahlian yang mempelajari e-commerce, digital marketing, social media management, dan entrepreneurship digital. Lulusan diharapkan mampu mengelola bisnis online.',
                'quota' => 60,
                'is_active' => true
            ],
            [
                'name' => 'Multimedia',
                'description' => 'Program keahlian yang mempelajari desain grafis, video editing, animasi, dan fotografi. Lulusan diharapkan mampu menghasilkan konten multimedia kreatif.',
                'quota' => 60,
                'is_active' => false // Contoh major yang inactive
            ],
        ];

        foreach ($majors as $major) {
            Major::create($major);
        }

        $this->command->info('✅ Created ' . count($majors) . ' majors');
    }
}
