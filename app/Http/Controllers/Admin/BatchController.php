<?php

namespace App\Http\Controllers\Admin;

use App\Models\Batch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BatchController extends Controller
{
    public function index()
    {
        $batches = Batch::withCount('registrations')->latest()->get();
        return view('admin.batches.index', compact('batches'));
    }

    public function create()
    {
        return view('admin.batches.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'is_active'  => 'boolean',
        ]);

        Batch::create($data);

        return redirect()->route('admin.batches.index')
            ->with('success', 'Gelombang pendaftaran berhasil ditambahkan!');
    }

    public function show(Batch $batch)
    {
        $batch->load(['registrations.user', 'registrations.major', 'schedules']);
        return view('admin.batches.show', compact('batch'));
    }

    public function edit(Batch $batch)
    {
        return view('admin.batches.edit', compact('batch'));
    }

    public function update(Request $request, Batch $batch)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'is_active'  => 'boolean',
        ]);

        $batch->update($data);

        return redirect()->route('admin.batches.index')
            ->with('success', 'Gelombang pendaftaran berhasil diupdate!');
    }

    public function destroy(Batch $batch)
    {
        // Cek apakah ada registrasi yang menggunakan batch ini
        if ($batch->registrations()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus gelombang yang sudah memiliki pendaftar!');
        }

        $batch->delete();

        return redirect()->route('admin.batches.index')
            ->with('success', 'Gelombang pendaftaran berhasil dihapus!');
    }

    /**
     * Toggle status aktif/nonaktif batch (buka/tutup pendaftaran)
     */
    public function toggleActive(Batch $batch)
    {
        $batch->update(['is_active' => !$batch->is_active]);

        $status = $batch->is_active ? 'dibuka' : 'ditutup';

        return back()->with('success', "Pendaftaran gelombang ini berhasil {$status}!");
    }
}
