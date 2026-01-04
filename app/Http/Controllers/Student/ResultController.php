<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Registration;
use Barryvdh\DomPDF\Facade\Pdf;

class ResultController extends Controller
{
    /**
     * Tampilkan halaman JADWAL ujian
     */
    public function schedule()
    {
        $registration = Registration::with(['batch', 'major', 'schedules']) // Load relasi schedules
            ->where('user_id', Auth::id())
            ->first();

        if (!$registration) {
            return redirect()->route('student.registration.create')
                ->with('error', 'Silakan daftar terlebih dahulu.');
        }

        // PERBAIKAN 1: Ambil jadwal (asumsi 1 siswa 1 jadwal interview aktif)
        $my_schedule = $registration->schedules()->first();

        // Kirim variabel 'my_schedule' ke view agar tidak Undefined Variable
        return view('student.exams.schedule', compact('registration', 'my_schedule'));
    }

    /**
     * Tampilkan halaman HASIL ujian
     */
    public function results()
    {
        $registration = Registration::with([
            'major',
            'batch',
            'examResults.interviewer', // Load hasil ujian
            'payment',
            'documents'
        ])
        ->where('user_id', Auth::id())
        ->first();

        if (!$registration) {
            return redirect()->route('student.registration.create')
                ->with('error', 'Anda belum melakukan registrasi.');
        }

        // PERBAIKAN 2: Ambil satu hasil ujian terakhir (Single Object)
        // View mengharapkan $exam_result (bukan collection $examResults)
        $exam_result = $registration->examResults()->latest()->first();

        // Tambahan logika: Jika belum ada di table exam_results, tapi ada field manual
        // Bisa ditambahkan mapping manual disini jika perlu.

        // PERBAIKAN 3: Hitung final score jika belum ada di database
        // (Opsional, jaga-jaga jika kolom final_score null)
        if ($exam_result && !$exam_result->final_score) {
            $exam_result->final_score = $exam_result->score; // Sementara pakai score interview
        }

        $finalStatus = $registration->status;

        // PERBAIKAN 4: Nama View disesuaikan dengan struktur folder (student.exams.results)
        return view('student.exams.results', compact('registration', 'exam_result', 'finalStatus'));
    }

    public function printCard()
    {
        $registration = Registration::with(['major', 'batch', 'personalDetail', 'schedules', 'documents'])
            ->where('user_id', Auth::id())
            ->first();

        if (!$registration) { abort(404); }

        $schedule = $registration->schedules()->first();
        if (!$schedule) {
            return back()->with('error', 'Jadwal ujian belum tersedia.');
        }

        // Ambil Foto
        $photoDoc = $registration->documents()->where('type', 'Foto')->first();
        $photoPath = $photoDoc ? storage_path('app/public/' . $photoDoc->file_path) : null;

        $pdf = Pdf::loadView('student.exams.card_pdf', compact('registration', 'schedule', 'photoPath'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('Kartu_Ujian_' . $registration->registration_code . '.pdf');
    }
}
