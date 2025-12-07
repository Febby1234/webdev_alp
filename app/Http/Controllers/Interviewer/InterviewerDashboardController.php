<?php

namespace App\Http\Controllers\Interviewer;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth;

class InterviewerDashboardController extends Controller
{
    public function index()
    {
        $assigned = Registration::where('status', 'for_interview')->get();

        return view('interviewer.dashboard', [
            'assigned' => $assigned
        ]);
    }
}