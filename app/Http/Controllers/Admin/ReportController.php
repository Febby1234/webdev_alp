<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Payment;
use App\Models\Major;
use App\Models\Batch;
use App\Models\ExamResult;
use App\Exports\RegistrationsExport;
use App\Exports\PaymentsExport;
use App\Exports\ExamResultsExport;
use App\Exports\MajorsExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Halaman utama laporan
     */
    public function index()
    {
        $stats = [
            'total_registrations' => Registration::count(),
            'accepted'            => Registration::where('status', 'accepted')->count(),
            'rejected'            => Registration::where('status', 'rejected')->count(),
            'in_progress'         => Registration::whereNotIn('status', ['accepted', 'rejected'])->count(),
            'total_payments'      => Payment::where('status', 'verified')->sum('amount'),
        ];

        $majors = Major::withCount('registrations')->get();
        $batches = Batch::withCount('registrations')->get();

        return view('admin.reports.index', compact('stats', 'majors', 'batches'));
    }

    /**
     * Halaman export laporan
     */
    public function export()
    {
        $majors = Major::all();
        $batches = Batch::all();

        return view('admin.reports.export', compact('majors', 'batches'));
    }

    /**
     * Export data pendaftar ke Excel
     */
    public function registrations(Request $request)
    {
        $filters = $request->only(['status', 'major_id', 'batch_id']);

        $filename = 'pendaftar_' . date('Y-m-d_His') . '.xlsx';

        return Excel::download(new RegistrationsExport($filters), $filename);
    }

    /**
     * Export data pembayaran ke Excel
     */
    public function payments(Request $request)
    {
        $filters = $request->only(['status']);

        $filename = 'pembayaran_' . date('Y-m-d_His') . '.xlsx';

        return Excel::download(new PaymentsExport($filters), $filename);
    }

    /**
     * Export hasil ujian ke Excel
     */
    public function exams(Request $request)
    {
        $filters = $request->only(['status', 'schedule_id', 'interviewer_id']);

        $filename = 'hasil_ujian_' . date('Y-m-d_His') . '.xlsx';

        return Excel::download(new ExamResultsExport($filters), $filename);
    }

    /**
     * Export data per jurusan ke Excel
     */
    public function majors(Request $request)
    {
        $batchId = $request->input('batch_id');

        $filename = 'statistik_jurusan_' . date('Y-m-d_His') . '.xlsx';

        return Excel::download(new MajorsExport($batchId), $filename);
    }
}
