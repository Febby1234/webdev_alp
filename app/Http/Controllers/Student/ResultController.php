<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Registration;

class ResultController extends Controller
{
    /**
     * Tampilkan halaman JADWAL ujian (Menangani route: exams.schedule)
     */
    public function schedule()
    {
        $registration = Registration::with(['batch', 'major']) // Sesuaikan relasi jika perlu
            ->where('user_id', Auth::id())
            ->first();

        // Cek registrasi
        if (!$registration) {
            return redirect()->route('student.registration.create')
                ->with('error', 'Silakan daftar terlebih dahulu.');
        }

        // Return view jadwal
        // Pastikan file view ini ada: resources/views/student/exams/schedule.blade.php
        return view('student.exams.schedule', [
            'registration' => $registration
        ]);
    }

    /**
     * Tampilkan halaman HASIL ujian (Menangani route: exams.results)
     * Sebelumnya fungsi ini bernama 'index', kita ubah jadi 'results' agar sesuai route.
     */
    public function results()
    {
        // Ambil data registrasi siswa
        $registration = Registration::with([
            'major',
            'batch',
            'examResults.interviewer',
            'payment',
            'documents'
        ])
        ->where('user_id', Auth::id())
        ->first();

        // Jika siswa belum registrasi
        if (!$registration) {
            return redirect()->route('student.registration.create')
                ->with('error', 'Anda belum melakukan registrasi.');
        }

        // Ambil nilai tes (jika ada)
        $examResults = $registration->examResults;

        // Status final: pending, accepted, rejected
        $finalStatus = $registration->status;

        // Return view hasil
        // Pastikan file view ini ada: resources/views/student/exams/results.blade.php
        // Atau sesuaikan jika nama foldernya 'student.result.index'
        return view('student.result.index', [
            'registration' => $registration,
            'examResults' => $examResults,
            'finalStatus' => $finalStatus
        ]);
    }
}
