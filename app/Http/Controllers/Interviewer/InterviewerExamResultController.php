<?php

namespace App\Http\Controllers\Interviewer;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\ExamResult;
use App\Models\Major;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InterviewerExamResultController extends Controller
{
    /**
     * Tampilkan daftar peserta (participants.index)
     */
    public function index(Request $request)
    {
        $query = Registration::with(['user', 'major', 'personalDetail', 'examResults', 'schedules'])
            ->whereIn('status', ['exam_scheduled', 'interview_scheduled', 'finished', 'accepted', 'rejected']);

        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('registration_code', 'like', '%' . $search . '%')
                    ->orWhereHas('personalDetail', function ($q) use ($search) {
                        $q->where('full_name', 'like', '%' . $search . '%');
                    });
            });
        }

        // Filter by status (pending/completed)
        if ($request->filled('status')) {
            if ($request->status == 'pending') {
                $query->whereDoesntHave('examResults');
            } elseif ($request->status == 'completed') {
                $query->whereHas('examResults');
            }
        }

        // Filter by major
        if ($request->filled('major_id')) {
            $query->where('major_id', $request->major_id);
        }

        $participants = $query->latest()->paginate(20);
        $majors = Major::where('is_active', true)->get();

        return view('interviewers.participants.index', compact('participants', 'majors'));
    }

    /**
     * Lihat detail peserta & form input nilai (participants.show)
     */
    public function show(Registration $registration)
    {
        $registration->load([
            'user',
            'major',
            'batch',
            'personalDetail',
            'parents',
            'schoolOrigin',
            'documents',
            'payment',
            'examResults.interviewer',
            'schedules'
        ]);

        // Cek apakah interviewer ini sudah memberikan nilai
        $examResult = $registration->examResults()
            ->where('interviewer_id', Auth::id())
            ->first();

        // Ambil schedule interview jika ada
        $schedule = $registration->schedules()->first();

        // Rename untuk view compatibility
        $participant = $registration;

        return view('interviewers.participants.show', compact('participant', 'examResult', 'schedule'));
    }

    /**
     * Simpan/Update nilai (participants.score)
     */
    public function score(Request $request, Registration $registration)
    {
        $validated = $request->validate([
            'score'  => 'required|integer|min:0|max:100',
            'status' => 'required|in:pass,fail,passed,failed',
            'notes'  => 'nullable|string|max:500',
        ]);

        // Normalize status
        $status = in_array($validated['status'], ['pass', 'passed']) ? 'pass' : 'fail';

        // Cek apakah sudah ada hasil dari interviewer ini
        $existingResult = ExamResult::where('registration_id', $registration->id)
            ->where('interviewer_id', Auth::id())
            ->first();

        if ($existingResult) {
            // Update existing
            $existingResult->update([
                'score'  => $validated['score'],
                'status' => $status,
                'notes'  => $validated['notes'],
            ]);
            $message = 'Nilai berhasil diperbarui.';
        } else {
            // Create new
            ExamResult::create([
                'registration_id' => $registration->id,
                'schedule_id'     => $registration->schedules()->first()?->id,
                'interviewer_id'  => Auth::id(),
                'score'           => $validated['score'],
                'status'          => $status,
                'notes'           => $validated['notes'],
            ]);
            $message = 'Nilai berhasil disimpan.';

            // Update status registrasi
            $registration->update(['status' => 'finished']);
        }

        return redirect()->route('interviewer.participants.index')
            ->with('success', $message);
    }

    /**
     * Tampilkan daftar jadwal (schedule.index)
     */
    public function scheduleIndex(Request $request)
    {
        $date = $request->get('date', date('Y-m-d'));

        // Jadwal untuk tanggal tertentu, grouped by time
        $schedules = Schedule::with(['registrations.user', 'registrations.personalDetail', 'registrations.major', 'registrations.examResults'])
            ->whereDate('date', $date)
            ->orderBy('time')
            ->get()
            ->groupBy(function ($schedule) {
                return date('H:i', strtotime($schedule->time));
            });

        // Jadwal mendatang (7 hari ke depan)
        $upcoming_schedules = Schedule::withCount('registrations')
            ->where('date', '>', today())
            ->where('date', '<=', today()->addDays(7))
            ->orderBy('date')
            ->orderBy('time')
            ->get();

        return view('interviewers.schedules.index', compact('schedules', 'upcoming_schedules'));
    }
}
