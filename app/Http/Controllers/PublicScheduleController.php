<?php

namespace App\Http\Controllers;

use App\Models\Schedule;

class PublicScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::orderBy('date')->get();
        return view('public.schedule.index', compact('schedules'));
    }
}
