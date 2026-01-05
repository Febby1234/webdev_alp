<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Payment;
use App\Models\Document;
use App\Models\User;
use App\Models\Major;
use App\Models\Batch;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Stats array untuk view
        $stats = [
            'total_students'        => User::where('role', 'student')->count(),
            'total_registrations'   => Registration::count(),

            // Pending Verifikasi (Data Baru)
            'pending_verifications' => Registration::where('status', 'pending')->count(),

            // Dokumen Pending (Opsional, sesuaikan status di DB dokumen)
            'pending_documents'     => Document::where('status', 'pending')->count(),

            // [PENTING] Gunakan Registration agar sinkron dengan Filter Dropdown tadi
            'pending_payments'      => Registration::where('status', 'paid')->count(),

            // [PENTING] Gunakan 'accepted' untuk yang Lulus
            'pass'                  => Registration::where('status', 'accepted')->count(),

            // Statistik Tambahan
            'rejected_students'     => Registration::where('status', 'rejected')->count(),
            'total_majors'          => Major::count(),
            'active_batches'        => Batch::where('is_active', true)->count(),
        ];

        // Pending documents untuk list di dashboard (ambil 5 terbaru)
        $pending_documents = Document::with(['registration.user', 'registration.personalDetail'])
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        // Recent registrations untuk list di dashboard
        $recent_registrations = Registration::with(['user', 'major', 'personalDetail'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'pending_documents', 'recent_registrations'));
    }
}
