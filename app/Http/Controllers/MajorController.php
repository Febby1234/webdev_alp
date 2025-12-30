<?php

namespace App\Http\Controllers;

use App\Models\Major;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    public function index()
    {
        $majors = Major::where('is_active', true)->get();
        return response()->json($majors);
    }

    public function show(Major $major)
    {
        return response()->json($major);
    }
}
