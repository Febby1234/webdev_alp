<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Document;
use App\Models\Payment;
use App\Models\Announcement;
use App\Models\Schedule; // <--- WAJIB: Import Model Schedule
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentDashboardController extends Controller
{
    /**
     * Halaman Utama Dashboard Siswa
     */
    public function index()
    {
        $user = Auth::user();

        // 1. Ambil data Registrasi User
        // Kita hapus 'schedules' dari with() karena kita pakai logika Batch
        $registration = Registration::with([
            'major',
            'batch',
            'personalDetail',
            'parents',
            'schoolOrigin',
            'documents',
            'payment',
            'examResults'
        ])->where('user_id', $user->id)->first();

        // --- DEFAULT VALUES (Nilai awal jika user baru daftar) ---
        $registration_step = 1;
        $registration_status = 'pending';
        $documents_uploaded = 0;
        $reqDocsConfig = config('registration.required_documents', ['ktp'=>'KTP','kk'=>'KK','ijazah'=>'Ijazah','foto'=>'Foto']);
        $total_documents = count($reqDocsConfig);
        $payment_status = 'unpaid';
        $exam_date = 'Belum Terjadwal';
        $document_status_list = [];

        // --- LOGIKA PROGRESS PENDAFTARAN ---
        if ($registration) {
            $registration_status = $registration->status;

            // Step 1: Biodata (Pasti sudah jika ada registration)
            $registration_step = 2;

            // Step 2: Data Orang Tua
            if ($registration->father_name && $registration->mother_name) {
                $registration_step = 3;
            }

            // Step 3: Data Sekolah
            if ($registration->school_name && $registration->graduation_year) {
                $registration_step = 4;
            }

            // Step 4: Dokumen
            $documents_uploaded = $registration->documents->count();
            $userDocs = $registration->documents;

            // Cek status per dokumen
            foreach ($reqDocsConfig as $key => $label) {
                $doc = $userDocs->first(function($item) use ($key) {
                    return strtolower($item->type) === strtolower($key);
                });
                $document_status_list[] = [
                    'name' => $label,
                    'status' => $doc ? $doc->status : 'unverified'
                ];
            }

            // Jika dokumen lengkap, lanjut ke pembayaran
            if ($documents_uploaded >= $total_documents) {
                $registration_step = 5;
            }

            // Step 5: Pembayaran
            $payment = Payment::where('registration_id', $registration->id)->latest()->first();

            if ($payment) {
                if ($payment->status == 'verified') {
                    $registration_step = 6; // Tahap Ujian
                    $payment_status = 'verified';
                } elseif ($payment->status == 'pending') {
                    $payment_status = 'pending';
                } else {
                    $payment_status = 'rejected';
                }
            }

            // --- [FIX] LOGIKA JADWAL UJIAN (BROADCAST) ---
            // Cari jadwal tipe 'exam' yang Batch ID-nya sama dengan mahasiswa
            if ($registration->batch_id) {
                $examSchedule = Schedule::where('batch_id', $registration->batch_id)
                                ->where('type', 'exam')
                                ->orderBy('date', 'asc') // Ambil jadwal terdekat
                                ->first();

                if ($examSchedule) {
                    $exam_date = \Carbon\Carbon::parse($examSchedule->date)->format('d F Y H:i') . ' WIB';
                }
            }
        }

        // Data Tambahan (Pengumuman & Biaya)
        $announcements = Announcement::latest()->limit(3)->get();
        $payment_amount = config('registration.registration_fee', 300000);

        return view('student.dashboard', [
            'registration' => $registration,
            'registration_step' => $registration_step,
            'registration_status' => $registration_status,
            'documents_uploaded' => $documents_uploaded,
            'total_documents' => $total_documents,
            'payment_status' => $payment_status,
            'payment_amount' => $payment_amount,
            'exam_date' => $exam_date,
            'announcements' => $announcements,
            'document_status' => $document_status_list,
        ]);
    }

    /**
     * Tampilkan Kartu Ujian (HTML View)
     */
    public function examCard()
    {
        $registration = Registration::where('user_id', Auth::id())
            ->with(['major', 'batch', 'personalDetail'])
            ->first();

        if (!$registration) {
            return redirect()->route('student.dashboard')->with('error', 'Belum registrasi.');
        }

        // [FIX] Ambil Jadwal berdasarkan Batch (Broadcast)
        $examSchedule = Schedule::where('batch_id', $registration->batch_id)
                        ->where('type', 'exam')
                        ->first();

        return view('student.exam-card', compact('registration', 'examSchedule'));
    }

    /**
     * Download Kartu Ujian (PDF)
     */
    public function downloadExamCard()
    {
        $registration = Registration::where('user_id', Auth::id())
            ->with(['major', 'batch', 'personalDetail'])
            ->first();

        if (!$registration) {
            return redirect()->route('student.dashboard')->with('error', 'Belum registrasi.');
        }

        // [FIX] Ambil Jadwal berdasarkan Batch (Broadcast)
        $examSchedule = Schedule::where('batch_id', $registration->batch_id)
                        ->where('type', 'exam')
                        ->first();

        $pdf = Pdf::loadView('student.exam-card-pdf', compact('registration', 'examSchedule'));

        return $pdf->download('kartu-ujian-' . ($registration->registration_code ?? 'new') . '.pdf');
    }

    // CATATAN PENTING:
    // Function public function schedule() SUDAH DIHAPUS DARI SINI.
    // Karena route '/student/exams/schedule' diurus oleh ResultController.php
}
