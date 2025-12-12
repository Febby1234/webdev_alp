<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementManagementController extends Controller
{
    public function index()
    {
        $ann = Announcement::all();
        return view('admin.announcements.index', compact('ann'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'is_public' => 'nullable|boolean',
        ]);

        Announcement::create($data);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement created.');
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'is_public' => 'nullable|boolean',
        ]);

        $announcement->update($data);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement updated.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return back()->with('success', 'Announcement deleted.');
    }
}
