<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Payment;
use App\Models\Document;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'total_students' => User::where('role', 'student')->count(),
            'pending_documents' => Document::where('status', 'pending')->count(),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'passed_students' => Registration::where('status', 'accepted')->count(),
            'rejected_students' => Registration::where('status', 'rejected')->count(),
        ]);
    }
}
