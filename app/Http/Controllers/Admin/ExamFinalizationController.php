<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\ExamResult;
use Illuminate\Http\Request;

class ExamFinalizationController extends Controller
{
    /**
     * Display a listing of registrations pending finalization.
     */
    public function index()
    {
        $registrations = Registration::with(['user', 'major', 'batch', 'examResults'])
            ->whereIn('status', ['exam_scheduled', 'interview_scheduled'])
            ->orWhere('status', 'like', '%exam%')
            ->paginate(10);

        return view('admin.exam-finalization.index', compact('registrations'));
    }

    /**
     * Show the form for finalizing exam results for a specific registration.
     */
    public function show(Registration $registration)
    {
        $examResults = $registration->examResults;

        // Jika belum ada exam result, redirect
        if ($examResults->isEmpty()) {
            return redirect()->route('admin.exam-finalization.index')
                ->with('warning', 'Peserta ini belum memiliki hasil ujian.');
        }

        $registration->load(['user', 'major', 'batch', 'documents', 'payment']);

        return view('admin.exam-finalization.show', compact('registration', 'examResults'));
    }

    /**
     * Finalize the exam result and update registration status.
     */
    public function finalize(Request $request, Registration $registration)
    {
        $validated = $request->validate([
            'final_decision' => 'required|in:passed,failed,rejected',
            'notes'          => 'nullable|string|max:500',
        ]);

        try {
            // Tentukan status berdasarkan keputusan
            $statusMap = [
                'passed'  => 'finished', // Kelulusan final
                'failed'  => 'finished', // Pengumuman kelulusan
                'rejected' => 'finished', // Pengumuman penolakan
            ];

            $registration->update([
                'status'  => $statusMap[$validated['final_decision']],
                'final_decision' => $validated['final_decision'],
                'decision_notes'  => $validated['notes'] ?? null,
            ]);

            return redirect()->route('admin.exam-finalization.index')
                ->with('success', 'Hasil ujian berhasil difinalisasi. Status: ' . ucfirst($validated['final_decision']));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyelesaikan: ' . $e->getMessage());
        }
    }

    /**
     * Bulk finalize exam results.
     */
    public function bulkFinalize(Request $request)
    {
        $validated = $request->validate([
            'registration_ids' => 'required|array',
            'registration_ids.*' => 'exists:registrations,id',
            'decision' => 'required|in:passed,failed,rejected',
        ]);

        try {
            $statusMap = [
                'passed'  => 'finished',
                'failed'  => 'finished',
                'rejected' => 'finished',
            ];

            Registration::whereIn('id', $validated['registration_ids'])
                ->update([
                    'status' => $statusMap[$validated['decision']],
                    'final_decision' => $validated['decision'],
                ]);

            return redirect()->route('admin.exam-finalization.index')
                ->with('success', count($validated['registration_ids']) . ' peserta berhasil difinalisasi.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal melakukan finalisasi massal: ' . $e->getMessage());
        }
    }

    /**
     * Generate and view exam results report.
     */
    public function report(Request $request)
    {
        $query = Registration::with(['user', 'major', 'batch', 'examResults'])
            ->where('status', 'finished');

        // Filter berdasarkan decision
        if ($request->filled('decision')) {
            $query->where('final_decision', $request->decision);
        }

        // Filter berdasarkan batch
        if ($request->filled('batch_id')) {
            $query->where('batch_id', $request->batch_id);
        }

        // Filter berdasarkan major
        if ($request->filled('major_id')) {
            $query->where('major_id', $request->major_id);
        }

        $registrations = $query->paginate(10);

        // Hitung statistik
        $stats = [
            'passed'  => Registration::where('final_decision', 'passed')->count(),
            'failed'  => Registration::where('final_decision', 'failed')->count(),
            'rejected' => Registration::where('final_decision', 'rejected')->count(),
            'total'   => Registration::where('status', 'finished')->count(),
        ];

        return view('admin.exam-finalization.report', compact('registrations', 'stats'));
    }

    /**
     * Export exam results report to CSV/Excel.
     */
    public function exportReport(Request $request)
    {
        try {
            $query = Registration::with(['user', 'major', 'batch', 'examResults'])
                ->where('status', 'finished');

            // Apply filters
            if ($request->filled('decision')) {
                $query->where('final_decision', $request->decision);
            }
            if ($request->filled('batch_id')) {
                $query->where('batch_id', $request->batch_id);
            }
            if ($request->filled('major_id')) {
                $query->where('major_id', $request->major_id);
            }

            $registrations = $query->get();

            // Prepare CSV headers and data
            $headers = ['No', 'Nama Siswa', 'Email', 'Jurusan', 'Gelombang', 'Keputusan', 'Nilai', 'Tgl Finalisasi'];
            $data = [];

            foreach ($registrations as $index => $registration) {
                $examScore = $registration->examResults->first()?->score ?? '-';
                $decision = $registration->final_decision ? ucfirst($registration->final_decision) : '-';

                $data[] = [
                    $index + 1,
                    $registration->user->name,
                    $registration->user->email,
                    $registration->major->name,
                    $registration->batch->name,
                    $decision,
                    $examScore,
                    $registration->updated_at->format('d/m/Y'),
                ];
            }

            // Generate CSV
            $filename = 'laporan_kelulusan_' . date('Y-m-d_His') . '.csv';

            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            $output = fopen('php://output', 'w');
            fputcsv($output, $headers);
            
            foreach ($data as $row) {
                fputcsv($output, $row);
            }
            
            fclose($output);
            exit;

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal export laporan: ' . $e->getMessage());
        }
    }
}
