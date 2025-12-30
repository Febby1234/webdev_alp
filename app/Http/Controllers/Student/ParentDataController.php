<?php

namespace App\Http\Controllers\Student;

use App\Models\ParentData;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ParentDataController extends Controller
{
    /**
     * Tampilkan form edit data orang tua
     */
    public function edit()
    {
        $registration = Registration::where('user_id', Auth::id())->first();

        if (!$registration) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Anda belum melakukan registrasi.');
        }

        $parents = $registration->parents;

        return view('student.parents.edit', compact('parents', 'registration'));
    }

    /**
     * Simpan data orang tua
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'registration_id' => 'required|exists:registrations,id',
            'father_name'     => 'nullable|string|max:255',
            'father_job'      => 'nullable|string|max:255',
            'father_phone'    => 'nullable|string|max:20',
            'mother_name'     => 'nullable|string|max:255',
            'mother_job'      => 'nullable|string|max:255',
            'mother_phone'    => 'nullable|string|max:20',
            'guardian_name'   => 'nullable|string|max:255',
            'contact'         => 'nullable|string|max:20',
        ]);

        ParentData::create($data);

        return redirect()->route('student.school.edit')
            ->with('success', 'Data orang tua berhasil disimpan!');
    }

    /**
     * Update data orang tua
     */
    public function update(Request $request, ParentData $parentData)
    {
        // Pastikan data ini milik user yang login
        if ($parentData->registration->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->validate([
            'father_name'   => 'nullable|string|max:255',
            'father_job'    => 'nullable|string|max:255',
            'father_phone'  => 'nullable|string|max:20',
            'mother_name'   => 'nullable|string|max:255',
            'mother_job'    => 'nullable|string|max:255',
            'mother_phone'  => 'nullable|string|max:20',
            'guardian_name' => 'nullable|string|max:255',
            'contact'       => 'nullable|string|max:20',
        ]);

        $parentData->update($data);

        return back()->with('success', 'Data orang tua berhasil diupdate!');
    }
}
