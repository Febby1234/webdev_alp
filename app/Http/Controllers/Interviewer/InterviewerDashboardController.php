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
        $interviewerId = Auth::id();

        // Total peserta yang bisa diinterview (status exam_scheduled atau interview_scheduled)
        $total_participants = Registration::whereIn('status', ['exam_scheduled', 'interview_scheduled'])->count();

        // Peserta yang belum diinterview (belum ada examResult dari interviewer ini)
        $pending_interviews = Registration::whereIn('status', ['exam_scheduled', 'interview_scheduled'])
            ->whereDoesntHave('examResults', function ($q) use ($interviewerId) {
                $q->where('interviewer_id', $interviewerId);
            })
            ->count();

        // Peserta yang sudah diinterview oleh interviewer ini
        $completed_interviews = ExamResult::where('interviewer_id', $interviewerId)->count();

        // Jadwal hari ini
        $today_schedules = Schedule::whereDate('date', today())->count();

        // Rata-rata nilai yang diberikan interviewer ini
        $average_score = ExamResult::where('interviewer_id', $interviewerId)->avg('score') ?? 0;

        // Interview minggu ini oleh interviewer ini
        $this_week_interviews = ExamResult::where('interviewer_id', $interviewerId)
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        // Peserta yang menunggu interview (untuk list)
        $pending_participants = Registration::with(['user', 'personalDetail', 'major'])
            ->whereIn('status', ['exam_scheduled', 'interview_scheduled'])
            ->whereDoesntHave('examResults', function ($q) use ($interviewerId) {
                $q->where('interviewer_id', $interviewerId);
            })
            ->latest()
            ->take(5)
            ->get();

        // Jadwal hari ini dengan peserta
        $today_schedule = Schedule::with(['registrations.user', 'registrations.personalDetail', 'registrations.major'])
            ->whereDate('date', today())
            ->get();

        return view('interviewers.dashboard', compact(
            'total_participants',
            'pending_interviews',
            'completed_interviews',
            'today_schedules',
            'average_score',
            'this_week_interviews',
            'pending_participants',
            'today_schedule'
        ));
    }
}
