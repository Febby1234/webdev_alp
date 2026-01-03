<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    /**
     * Tampilkan semua pengumuman
     */
    public function index()
    {
        $announcements = Announcement::latest()->paginate(20);
        return view('admin.announcements.index', compact('announcements'));
    }

    /**
     * Form buat pengumuman baru
     */
    public function create()
    {
        return view('admin.announcements.create');
    }

    /**
     * Simpan pengumuman baru
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'content'      => 'required|string|min:10',
            'banner_image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        // Handle upload banner
        if ($request->hasFile('banner_image')) {
            $data['banner_image'] = $request->file('banner_image')->store('announcements', 'public');
        }

        Announcement::create($data);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil dipublish!');
    }

    /**
     * Tampilkan detail pengumuman
     */
    public function show(Announcement $announcement)
    {
        return view('admin.announcements.show', compact('announcement'));
    }

    /**
     * Form edit pengumuman
     */
    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    /**
     * Update pengumuman
     */
    public function update(Request $request, Announcement $announcement)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'content'      => 'required|string|min:10',
            'banner_image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        // Handle hapus banner
        if ($request->has('remove_banner') && $announcement->banner_image) {
            Storage::disk('public')->delete($announcement->banner_image);
            $data['banner_image'] = null;
        }

        // Handle upload banner baru
        if ($request->hasFile('banner_image')) {
            // Hapus banner lama jika ada
            if ($announcement->banner_image) {
                Storage::disk('public')->delete($announcement->banner_image);
            }
            $data['banner_image'] = $request->file('banner_image')->store('announcements', 'public');
        }

        $announcement->update($data);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil diupdate!');
    }

    /**
     * Hapus pengumuman
     */
    public function destroy(Announcement $announcement)
    {
        // Hapus banner jika ada
        if ($announcement->banner_image) {
            Storage::disk('public')->delete($announcement->banner_image);
        }

        $announcement->delete();

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil dihapus!');
    }
}
