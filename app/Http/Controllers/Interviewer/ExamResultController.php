<?php

namespace App\Http\Controllers\Interviewer;

use App\Http\Controllers\Controller;
use App\Models\ExamResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamResultController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'registration_id' => 'required|exists:registrations,id',
            'score' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string'
        ]);

        $data['interviewer_id'] = Auth::id();
        $data['result'] = $data['score'] >= 65 ? 'pass' : 'fail';

        ExamResult::create($data);

        return back()->with('success', 'Exam score saved.');
    }
}
