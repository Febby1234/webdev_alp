<?php

namespace App\Http\Controllers\Interviewer;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\ExamResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InterviewerExamResultController extends Controller
{
    /**
     * Tampilkan daftar siswa yang akan/sudah diuji
     */
    public function index()
    {
        $registrations = Registration::with(['user', 'major', 'personalDetail', 'examResults'])
            ->whereIn('status', ['exam_scheduled', 'interview_scheduled', 'finished', 'accepted', 'rejected'])
            ->paginate(20);

        return view('interviewer.exam.index', compact('registrations'));
    }

    /**
     * Form input nilai ujian
     */
    public function create($registration_id)
    {
        $registration = Registration::with(['user', 'major', 'personalDetail'])
            ->findOrFail($registration_id);

        return view('interviewer.exam.create', compact('registration'));
    }

    /**
     * Simpan hasil ujian
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'registration_id' => 'required|exists:registrations,id',
            'schedule_id'     => 'nullable|exists:schedules,id',
            'score'           => 'required|integer|min:0|max:100',
            'status'          => 'required|in:pass,fail', // FIXED: Changed from 'result' to 'status'
            'notes'           => 'nullable|string|max:500',
        ]);

        // Cek apakah sudah ada hasil ujian untuk pendaftar ini oleh interviewer ini
        $existingResult = ExamResult::where('registration_id', $validated['registration_id'])
            ->where('interviewer_id', Auth::id())
            ->first();

        if ($existingResult) {
            return redirect()->back()->with('error', 'Anda sudah memberikan nilai untuk pendaftar ini.');
        }

        // Simpan hasil ujian
        ExamResult::create([
            'registration_id' => $validated['registration_id'],
            'schedule_id'     => $validated['schedule_id'] ?? null,
            'interviewer_id'  => Auth::id(),
            'score'           => $validated['score'],
            'status'          => $validated['status'],
            'notes'           => $validated['notes'],
        ]);

        // Update status registrasi
        $registration = Registration::findOrFail($validated['registration_id']);
        $registration->update(['status' => 'finished']);

        return redirect()->route('interviewer.exam.index')
            ->with('success', 'Hasil ujian berhasil disimpan.');
    }

    /**
     * Edit hasil ujian
     */
    public function edit($id)
    {
        $examResult = ExamResult::with(['registration.user', 'registration.major', 'registration.personalDetail'])
            ->where('interviewer_id', Auth::id())
            ->findOrFail($id);

        return view('interviewer.exam.edit', compact('examResult'));
    }

    /**
     * Update hasil ujian
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'score'  => 'required|integer|min:0|max:100',
            'status' => 'required|in:pass,fail', // FIXED: Changed from 'result' to 'status'
            'notes'  => 'nullable|string|max:500',
        ]);

        $examResult = ExamResult::where('interviewer_id', Auth::id())->findOrFail($id);
        $examResult->update($validated);

        return redirect()->route('interviewer.exam.index')
            ->with('success', 'Hasil ujian berhasil diperbarui.');
    }

    /**
     * Lihat detail profil peserta
     */
    public function viewProfile($registration_id)
    {
        $registration = Registration::with([
            'user',
            'major',
            'batch',
            'personalDetail',
            'parents',
            'schoolOrigin',
            'documents',
            'payment',
            'examResults'
        ])->findOrFail($registration_id);

        return view('interviewer.exam.profile', compact('registration'));
    }
}
