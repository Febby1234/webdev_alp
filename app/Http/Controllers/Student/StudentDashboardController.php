<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $registration = Registration::with([
            'major',
            'batch',
            'personalDetail',
            'parents',
            'schoolOrigin',
            'documents',
            'payment',
            'examResults',
            'schedules'
        ])->where('user_id', Auth::id())->first();

        return view('student.dashboard', [
            'registration' => $registration,
        ]);
    }

    /**
     * Tampilkan kartu ujian siswa
     */
    public function examCard()
    {
        $registration = Registration::where('user_id', Auth::id())
            ->with(['major', 'batch', 'personalDetail', 'schedules' => function($query) {
                $query->where('type', 'exam');
            }])
            ->first();

        if (!$registration) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Anda belum melakukan registrasi.');
        }

        // Cek apakah sudah ada jadwal ujian
        $examSchedule = $registration->schedules->first();

        return view('student.exam-card', compact('registration', 'examSchedule'));
    }

    /**
     * Download kartu ujian dalam format PDF
     */
    public function downloadExamCard()
    {
        $registration = Registration::where('user_id', Auth::id())
            ->with(['major', 'batch', 'personalDetail', 'schedules' => function($query) {
                $query->where('type', 'exam');
            }])
            ->first();

        if (!$registration) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Anda belum melakukan registrasi.');
        }

        $examSchedule = $registration->schedules->first();

        $pdf = Pdf::loadView('student.exam-card-pdf', compact('registration', 'examSchedule'));

        return $pdf->download('kartu-ujian-' . $registration->registration_code . '.pdf');
    }

    /**
     * Lihat jadwal siswa
     */
    public function schedule()
    {
        $registration = Registration::where('user_id', Auth::id())
            ->with(['schedules.batch'])
            ->first();

        if (!$registration) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Anda belum melakukan registrasi.');
        }

        $schedules = $registration->schedules;

        return view('student.schedule', compact('schedules', 'registration'));
    }
}
