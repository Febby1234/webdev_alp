<?php

namespace App\Http\Controllers;

use App\Models\ExamResult;
use Illuminate\Http\Request;

class ExamResultController extends Controller
{
    public function store(Request $request)
    {
        return ExamResult::create($request->all());
    }

    public function update(Request $request, ExamResult $examResult)
    {
        $examResult->update($request->all());
        return $examResult;
    }
}
