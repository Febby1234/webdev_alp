<?php

namespace App\Http\Controllers\Admin;

use App\Models\Major;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MajorController extends Controller
{
    public function index()
    {
        $majors = Major::withCount('registrations')->get();
        return view('admin.majors.index', compact('majors'));
    }

    public function create()
    {
        return view('admin.majors.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'quota'       => 'required|integer|min:1',
            'is_active'   => 'boolean'
        ]);

        Major::create($data);

        return redirect()->route('admin.majors.index')
            ->with('success', 'Jurusan berhasil ditambahkan!');
    }

    public function show(Major $major)
    {
        $major->load(['registrations.user', 'registrations.batch']);
        return view('admin.majors.show', compact('major'));
    }

    public function edit(Major $major)
    {
        return view('admin.majors.edit', compact('major'));
    }

    public function update(Request $request, Major $major)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'quota'       => 'required|integer|min:1',
            'is_active'   => 'boolean'
        ]);

        $major->update($data);

        return redirect()->route('admin.majors.index')
            ->with('success', 'Jurusan berhasil diupdate!');
    }

    public function destroy(Major $major)
    {
        // Cek apakah ada registrasi yang menggunakan major ini
        if ($major->registrations()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus jurusan yang sudah memiliki pendaftar!');
        }

        $major->delete();

        return redirect()->route('admin.majors.index')
            ->with('success', 'Jurusan berhasil dihapus!');
    }

    /**
     * Toggle status aktif/nonaktif jurusan
     */
    public function toggleActive(Major $major)
    {
        $major->update(['is_active' => !$major->is_active]);

        $status = $major->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Jurusan berhasil {$status}!");
    }
}
