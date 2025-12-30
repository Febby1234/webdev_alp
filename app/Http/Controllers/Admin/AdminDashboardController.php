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
        return view('admin.dashboard', [
            'total_students'     => User::where('role', 'student')->count(),
            'total_registrations' => Registration::count(),
            'pending_documents'  => Document::where('status', 'pending')->count(),
            'pending_payments'   => Payment::where('status', 'pending')->count(),
            'accepted_students'  => Registration::where('status', 'accepted')->count(),
            'rejected_students'  => Registration::where('status', 'rejected')->count(),
            'total_majors'       => Major::count(),
            'active_batches'     => Batch::count(),
        ]);
    }
}
