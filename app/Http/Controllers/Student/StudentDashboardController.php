<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $registration = Registration::where('user_id', Auth::id())->first();

        return view('student.dashboard', [
            'registration' => $registration,
        ]);
    }
}
