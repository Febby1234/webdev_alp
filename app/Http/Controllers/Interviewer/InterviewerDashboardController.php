<?php

namespace App\Http\Controllers\Interviewer;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\ExamResult;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;

class InterviewerDashboardController extends Controller
{
    public function index()
    {
        // Ambil statistik untuk interviewer
        $stats = [
            'total_exams' => ExamResult::where('interviewer_id', Auth::id())->count(),
            'today_exams' => Registration::whereHas('examResults', function($q) {
                $q->where('interviewer_id', Auth::id())
                  ->whereDate('created_at', today());
            })->count(),
            'pending_exams' => Registration::where('status', 'exam_scheduled')
                ->whereDoesntHave('examResults')
                ->count(),
            'pass_count' => ExamResult::where('interviewer_id', Auth::id())
                ->where('status', 'pass')
                ->count(),
            'fail_count' => ExamResult::where('interviewer_id', Auth::id())
                ->where('status', 'fail')
                ->count(),
        ];

        // Ambil jadwal ujian hari ini
        $today_schedule = Schedule::with(['batch', 'registrations.user', 'registrations.major', 'registrations.personalDetail'])
            ->where('type', 'exam')
            ->whereDate('date', today())
            ->get();

        return view('interviewer.dashboard', compact('stats', 'today_schedule'));
    }
}
