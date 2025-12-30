<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Announcement;
use App\Models\User;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        $announcements = [
            [
                'title' => 'Pendaftaran Gelombang 1 Dibuka!',
                'content' => 'Kami dengan senang hati mengumumkan bahwa pendaftaran siswa baru gelombang 1 telah dibuka. Buruan daftar sebelum kuota penuh! Pendaftaran akan ditutup pada akhir bulan ini.',
                'user_id' => $admin->id,
            ],
            [
                'title' => 'Jadwal Ujian Masuk Gelombang 1',
                'content' => 'Ujian masuk untuk pendaftar gelombang 1 akan dilaksanakan pada tanggal 15 Januari 2025. Mohon calon siswa untuk mempersiapkan diri dengan baik. Jangan lupa membawa kartu ujian dan alat tulis.',
                'user_id' => $admin->id,
            ],
            [
                'title' => 'Pengumuman Hasil Seleksi',
                'content' => 'Hasil seleksi penerimaan siswa baru akan diumumkan melalui website dan email masing-masing pendaftar. Pastikan email yang didaftarkan aktif dan cek secara berkala.',
                'user_id' => $admin->id,
            ],
            [
                'title' => 'Syarat dan Ketentuan Pendaftaran',
                'content' => 'Calon siswa wajib melengkapi semua dokumen yang diperlukan: KTP, Ijazah, Foto 3x4, dan Kartu Keluarga. Biaya pendaftaran sebesar Rp 250.000 dibayarkan melalui transfer bank.',
                'user_id' => $admin->id,
            ],
            [
                'title' => 'Open House SMK Teknologi Nusantara',
                'content' => 'Kami mengundang calon siswa dan orang tua untuk menghadiri Open House yang akan dilaksanakan pada hari Sabtu, 20 Januari 2025. Acara ini akan memberikan informasi lengkap tentang program keahlian dan fasilitas sekolah.',
                'user_id' => $admin->id,
            ],
        ];

        foreach ($announcements as $announcement) {
            Announcement::create($announcement);
        }

        $this->command->info('✅ Created ' . count($announcements) . ' announcements');
    }
}
