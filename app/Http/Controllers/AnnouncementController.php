<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('user')->latest()->get();
        return response()->json($announcements);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'banner_image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('announcements', 'public');
        }

        $validated['user_id'] = Auth::id();

        $announcement = Announcement::create($validated);

        return response()->json([
            'message' => 'Announcement created successfully',
            'data' => $announcement
        ], 201);
    }

    public function show(Announcement $announcement)
    {
        return response()->json($announcement->load('user'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'banner_image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        if ($request->hasFile('banner_image')) {
            // Delete old image if exists
            if ($announcement->banner_image && Storage::disk('public')->exists($announcement->banner_image)) {
                Storage::disk('public')->delete($announcement->banner_image);
            }
            $validated['banner_image'] = $request->file('banner_image')->store('announcements', 'public');
        }

        $announcement->update($validated);

        return response()->json([
            'message' => 'Announcement updated successfully',
            'data' => $announcement
        ]);
    }

    public function destroy(Announcement $announcement)
    {
        // Delete image if exists
        if ($announcement->banner_image && Storage::disk('public')->exists($announcement->banner_image)) {
            Storage::disk('public')->delete($announcement->banner_image);
        }

        $announcement->delete();

        return response()->json([
            'message' => 'Announcement deleted successfully'
        ]);
    }
}
