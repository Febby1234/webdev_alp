<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Document;
use App\Models\Payment;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Ambil data Registrasi User beserta relasinya
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
        ])->where('user_id', $user->id)->first();

        // --- DEFAULT VALUES (Jika user baru daftar akun) ---
        $registration_step = 1;
        $registration_status = 'pending';
        $documents_uploaded = 0;
        // Ambil jumlah dokumen wajib dari config, default 4 (KTP, KK, Ijazah, Foto)
        $total_documents = count(config('registration.required_documents', ['a','b','c','d']));
        $payment_status = 'unpaid';
        $exam_date = 'Belum Terjadwal';
        $document_status_list = [];

        // --- LOGIKA MENGHITUNG PROGRESS (STEP 1-6) ---
        if ($registration) {
            $registration_status = $registration->status;

            // Step 1: Registrasi Awal (Biodata) -> Sudah pasti lewat jika ada $registration
            $registration_step = 2; // Default masuk step orang tua

            // Cek Step 2: Data Orang Tua
            if ($registration->father_name && $registration->mother_name) {
                $registration_step = 3;
            }

            // Cek Step 3: Data Sekolah
            if ($registration->school_name && $registration->graduation_year) {
                $registration_step = 4;
            }

            // Cek Step 4: Dokumen
            $documents_uploaded = $registration->documents->count();

            // Siapkan list status dokumen untuk Card di Dashboard
            $reqDocs = array_keys(config('registration.required_documents', ['ktp'=>'KTP','kk'=>'KK','ijazah'=>'Ijazah','foto'=>'Foto']));

            foreach ($reqDocs as $type) {
                // Cari dokumen spesifik di koleksi yg sudah di-load
                $doc = $registration->documents->where('type', $type)->first();
                $document_status_list[] = [
                    'name' => strtoupper($type),
                    'status' => $doc ? $doc->status : 'unverified' // unverified artinya belum upload
                ];
            }

            // Jika jumlah dokumen upload >= total wajib, lanjut step pembayaran
            if ($documents_uploaded >= $total_documents) {
                $registration_step = 5;
            }

            // Cek Step 5: Pembayaran
            // Ambil payment terakhir
            $payment = Payment::where('registration_id', $registration->id)->latest()->first();

            if ($payment) {
                if ($payment->status == 'verified') {
                    $registration_step = 6; // Selesai / Menunggu Ujian
                    $payment_status = 'verified';
                } elseif ($payment->status == 'pending') {
                    $payment_status = 'pending';
                    // Tetap di step 5 tapi status pending
                } else {
                    $payment_status = 'rejected';
                }
            }

            // Cek Jadwal Ujian
            $examSchedule = $registration->schedules->where('type', 'exam')->first();
            if ($examSchedule) {
                $exam_date = \Carbon\Carbon::parse($examSchedule->date)->format('d F Y H:i');
            }
        }

        // Ambil Pengumuman & Biaya
        $announcements = Announcement::latest()->limit(3)->get();
        // Pastikan config fee benar
        $payment_amount = config('registration.registration_fee', 300000);

        // Kirim semua variabel yang dibutuhkan View
        return view('student.dashboard', [
            'registration' => $registration, // Data object asli (untuk jaga-jaga)
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
