<?php

namespace App\Http\Controllers\Interviewer;

use App\Http\Controllers\Controller;
use App\Models\Registration;

class InterviewerDashboardController extends Controller
{
    public function index()
    {
        $data = Registration::with('personalDetail')
                ->where('status', 'for_interview')
                ->get();

        return view('interviewer.dashboard', compact('data'));
    }
}
