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
            'pending_verifications' => Registration::where('status', 'pending')->count(),
            'pending_documents'     => Document::where('status', 'pending')->count(),
            'pending_payments'      => Payment::where('status', 'pending')->count(),
            'accepted_students'     => Registration::where('status', 'accepted')->count(),
            'rejected_students'     => Registration::where('status', 'rejected')->count(),
            'pass'                  => Registration::where('status', 'accepted')->count(),
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
