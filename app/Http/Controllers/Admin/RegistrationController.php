<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Major;
use App\Models\Batch;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    /**
     * Tampilkan semua registrasi
     */
    public function index()
    {
        $registrations = Registration::with(['user', 'major', 'batch'])
            ->latest()
            ->paginate(20);

        return view('admin.registrations.index', compact('registrations'));
    }

    /**
     * Tampilkan registrasi berdasarkan status
     */
    public function byStatus($status)
    {
        $registrations = Registration::with(['user', 'major', 'batch'])
            ->where('status', $status)
            ->latest()
            ->paginate(20);

        return view('admin.registrations.index', compact('registrations', 'status'));
    }

    /**
     * Tampilkan detail registrasi lengkap
     */
    public function show(Registration $registration)
    {
        $registration->load([
            'user', 'major', 'batch',
            'personalDetail', 'parents', 'schoolOrigin',
            'documents', 'payment', 'examResults.interviewer', 'schedules'
        ]);

        return view('admin.registrations.show', compact('registration'));
    }

    /**
     * Update status registrasi
     */
    public function updateStatus(Request $request, Registration $registration)
    {
        $request->validate([
            'status' => 'required|in:pending,documents_pending,documents_verified,payment_pending,paid,exam_scheduled,interview_scheduled,finished,accepted,rejected',
        ]);

        $registration->update(['status' => $request->status]);

        return back()->with('success', 'Status registrasi berhasil diupdate!');
    }

    /**
     * Finalisasi kelulusan - set ke accepted atau rejected
     */
    public function finalize(Request $request, Registration $registration)
    {
        $request->validate([
            'final_status' => 'required|in:accepted,rejected',
            'note'         => 'nullable|string|max:500',
        ]);

        $registration->update([
            'status' => $request->final_status,
        ]);

        // TODO: Kirim email notification ke student

        return back()->with('success', 'Kelulusan berhasil difinalisasi!');
    }

    /**
     * Export data registrasi
     */
    public function export(Request $request)
    {
        // TODO: Implement Excel export
        // Bisa pakai Laravel Excel package

        return back()->with('info', 'Export feature coming soon!');
    }

    /**
     * Hapus registrasi (hanya jika belum ada data terkait)
     */
    public function destroy(Registration $registration)
    {
        // Cek apakah ada data terkait
        if ($registration->documents()->count() > 0 ||
            $registration->payment ||
            $registration->examResults()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus registrasi yang sudah memiliki data terkait!');
        }

        $registration->delete();

        return redirect()->route('admin.registrations.index')
            ->with('success', 'Registrasi berhasil dihapus!');
    }
}
