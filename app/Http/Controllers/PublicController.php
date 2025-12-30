<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Models\Announcement;
use App\Models\Schedule;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function welcome()
    {
        $stats = [
            'total_students' => 1000,
            'total_majors' => Major::count(),
        ];

        $majors = Major::where('is_active', true)
            ->withCount('registrations')
            ->limit(3)
            ->get();

        $announcements = Announcement::latest()
            ->limit(4)
            ->get();

        return view('welcome', compact('stats', 'majors', 'announcements'));
    }

    public function majors()
    {
        $majors = Major::where('is_active', true)
            ->withCount('registrations')
            ->get();

        return view('public.majors', compact('majors'));
    }

    public function requirements()
    {
        return view('public.requirements');
    }

    public function schedules()
    {
        $schedules = Schedule::orderBy('date')->orderBy('time')->get();
        return view('public.schedules', compact('schedules'));
    }

    public function announcements()
    {
        $announcements = Announcement::where('is_published', true)
            ->latest()
            ->paginate(10);

        return view('public.announcements', compact('announcements'));
    }
}
