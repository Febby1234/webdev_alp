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
            ->whereIn('status', [
                'documents_verified',
                'verified',
                'payment_verified', 
                'exam_scheduled',
                'interview_scheduled',
                'finished',
                'accepted',
                'rejected'
            ]);
        // Filter Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('registration_code', 'like', '%' . $search . '%')
                    ->orWhereHas('personalDetail', function ($q) use ($search) {
                        $q->where('full_name', 'like', '%' . $search . '%');
                    });
            });
        }

        // Filter Status (Sudah dinilai / Belum)
        if ($request->filled('status')) {
            if ($request->status == 'pending') {
                $query->whereDoesntHave('examResults');
            } elseif ($request->status == 'completed') {
                $query->whereHas('examResults');
            }
        }

        // Filter Jurusan
        if ($request->filled('major_id')) {
            $query->where('major_id', $request->major_id);
        }

        $participants = $query->latest()->paginate(20);
        $majors = Major::where('is_active', true)->get();

        return view('interviewers.participants.index', compact('participants', 'majors'));
    }

    /**
     * Detail Peserta & Form Input Nilai
     */
    public function show(Registration $registration)
    {
        // Load relasi yang dibutuhkan
        $registration->load([
            'major', 'batch', 'personalDetail', 'documents', 'examResults', 'schedules'
        ]);

        // 1. Cek nilai existing dari interviewer ini
        $examResult = $registration->examResults()
            ->where('interviewer_id', Auth::id())
            ->first();

        // 2. [FIX] Ambil Data Jadwal (Agar tidak error undefined variable)
        // Kita cari jadwal interview yang nempel di registrasi ini
        $schedule = $registration->schedules()->where('type', 'interview')->first();

        // Fallback: Jika tidak ada jadwal interview khusus, ambil jadwal apapun yang ada (misal ujian)
        // atau ambil dari Batch (Broadcast system) jika kamu pakai sistem broadcast untuk interview juga
        if (!$schedule) {
            $schedule = \App\Models\Schedule::where('batch_id', $registration->batch_id)
                        ->where('type', 'interview')
                        ->first();
        }

        // Data pendukung
        $participant = $registration;

        // 3. Kirim $schedule ke View
        return view('interviewers.participants.show', compact('participant', 'examResult', 'schedule'));
    }

    /**
     * PROSES SIMPAN NILAI (FIXED LOGIC)
     */
    public function score(Request $request, Registration $registration)
    {
        // 1. Validasi Input (2 Nilai: Tulis & Wawancara)
        $validated = $request->validate([
            'written_score'   => 'required|numeric|min:0|max:100',
            'interview_score' => 'required|numeric|min:0|max:100',
            'status'          => 'required|in:pass,fail',
            'notes'           => 'nullable|string|max:1000',
        ]);

        // 2. Hitung Nilai Akhir (Misal: Rata-rata)
        // Bisa diubah bobotnya, misal: (Tulis * 0.4) + (Wawancara * 0.6)
        $finalScore = ($validated['written_score'] + $validated['interview_score']) / 2;

        // 3. Simpan ke Database (Update or Create)
        ExamResult::updateOrCreate(
            [
                'registration_id' => $registration->id,
                'interviewer_id'  => Auth::id(), // Kunci unik biar 1 interviewer 1 nilai
            ],
            [
                'written_score'   => $validated['written_score'],
                'interview_score' => $validated['interview_score'],
                'final_score'     => $finalScore,
                'score'           => $finalScore,
                'status'          => $validated['status'],
                'notes'           => $validated['notes'],
                // Ambil schedule_id jika ada relasinya
                'schedule_id'     => $registration->schedules()->first()?->id,
            ]
        );

        // 4. Update Status Registrasi Utama
        // Jika Lulus -> finished (atau accepted)
        // Jika Gagal -> rejected
        // Disini kita set 'finished' dulu agar Admin Pusat yang memvalidasi final statusnya,
        // atau langsung 'accepted'/'rejected' juga boleh.

        $newStatus = ($validated['status'] == 'pass') ? 'accepted' : 'rejected';
        $registration->update(['status' => $newStatus]);

        return redirect()->route('interviewer.participants.index')
            ->with('success', 'Nilai berhasil disimpan. Mahasiswa dapat segera melihat hasilnya.');
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
