<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Registration;
use App\Models\ExamResult;

class ResultController extends Controller
{
    /**
     * Tampilkan halaman hasil seleksi
     */
    public function index()
    {
        // Ambil data registrasi siswa
        $registration = Registration::with([
            'major',
            'batch',
            'examResults',
            'payment',
            'documents'
        ])
        ->where('user_id', Auth::id())
        ->first();

        // Jika siswa belum registrasi
        if (!$registration) {
            return redirect()->route('student.register')
                ->with('error', 'Anda belum melakukan registrasi.');
        }

        // Ambil nilai tes (jika ada)
        $examResults = $registration->examResults;

        // Status final: pending, passed, failed 
        $finalStatus = $registration->status;

        return view('student.result.index', [
            'registration' => $registration,
            'examResults' => $examResults,
            'finalStatus' => $finalStatus
        ]);
    }
}