<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        return Announcement::all();
    }

    public function store(Request $request)
    {
        return Announcement::create(
            $request->validate([
                'title'   => 'required',
                'content' => 'required'
            ])
        );
    }

    public function show(Announcement $announcement)
    {
        return $announcement;
    }

    public function update(Request $request, Announcement $announcement)
    {
        $announcement->update($request->all());
        return $announcement;
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return response()->json(['message' => 'Announcement deleted']);
    }
}
