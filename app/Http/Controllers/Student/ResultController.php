<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Registration;
use App\Models\Schedule; // <--- WAJIB IMPORT INI
use Barryvdh\DomPDF\Facade\Pdf;

class ResultController extends Controller
{
    /**
     * Tampilkan halaman JADWAL ujian
     */
    public function schedule()
    {
        $registration = Registration::with(['batch', 'major'])
            ->where('user_id', Auth::id())
            ->first();

        if (!$registration) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Silakan daftar terlebih dahulu.');
        }

        // --- PERBAIKAN UTAMA: LOGIKA BROADCAST ---
        // Kita tidak pakai $registration->schedules() lagi.
        // Kita cari jadwal yang Batch ID-nya sama dengan mahasiswa.

        $schedules = Schedule::where('batch_id', $registration->batch_id)
                     ->orderBy('date', 'asc')
                     ->get();

        // Debugging: Jika $schedules kosong, berarti belum ada jadwal untuk gelombang ini

        // Kita kirim '$schedules' (JAMAK) agar cocok dengan View
        return view('student.exams.schedule', compact('registration', 'schedules'));
    }

    /**
     * Tampilkan halaman HASIL ujian
     */
    public function results()
    {
        $registration = Registration::with([
            'major',
            'batch',
            'examResults.interviewer',
            'payment',
            'documents'
        ])
        ->where('user_id', Auth::id())
        ->first();

        if (!$registration) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Anda belum melakukan registrasi.');
        }

        // Ambil satu hasil ujian terakhir
        $exam_result = $registration->examResults()->latest()->first();

        // Hitung final score jika null
        if ($exam_result && !$exam_result->final_score) {
            $exam_result->final_score = $exam_result->score;
        }

        $finalStatus = $registration->status;

        return view('student.exams.results', compact('registration', 'exam_result', 'finalStatus'));
    }

    /**
     * Cetak Kartu Ujian (PDF)
     */
    public function printCard()
    {
        \Carbon\Carbon::setLocale('id');
        $registration = Registration::with(['major', 'batch', 'personalDetail', 'documents'])
            ->where('user_id', Auth::id())
            ->first();

        if (!$registration) { abort(404); }

        // --- PERBAIKAN UTAMA: LOGIKA BROADCAST DI PDF ---
        // Cari jadwal ujian (exam) berdasarkan Batch ID mahasiswa
        $schedule = Schedule::where('batch_id', $registration->batch_id)
                    ->where('type', 'exam')
                    ->first();

        if (!$schedule) {
            return back()->with('error', 'Jadwal ujian belum tersedia untuk gelombang Anda.');
        }

        // Ambil Foto Profil
        $photoDoc = $registration->documents()->where('type', 'Foto')->first();
        // Pastikan path foto benar (sesuaikan dengan storage link kamu)
        $photoPath = $photoDoc ? public_path('storage/' . $photoDoc->file_path) : null;

        // Jika pakai storage_path kadang error di server tertentu, bisa coba public_path
        if (!$photoPath || !file_exists($photoPath)) {
             // Fallback jika pakai storage_path
             $photoPath = $photoDoc ? storage_path('app/public/' . $photoDoc->file_path) : null;
        }


        $pdf = Pdf::loadView('student.exams.card-pdf', compact('registration', 'schedule', 'photoPath'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Kartu_Ujian.pdf');
    }
}
