<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Major;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->take(3)->get();
        $majors = Major::where('is_active', true)->get();

        return view('welcome', compact('announcements', 'majors'));
    }
}
