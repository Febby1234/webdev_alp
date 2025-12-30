<?php

namespace App\Http\Controllers\Student;

use App\Models\SchoolOrigin;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SchoolOriginController extends Controller
{
    /**
     * Tampilkan form edit asal sekolah
     */
    public function edit()
    {
        $registration = Registration::where('user_id', Auth::id())->first();

        if (!$registration) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Anda belum melakukan registrasi.');
        }

        $school = $registration->schoolOrigin;

        return view('student.school.edit', compact('school', 'registration'));
    }

    /**
     * Simpan data asal sekolah
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'registration_id'     => 'required|exists:registrations,id',
            'school_origin_name'  => 'required|string|max:255',
            'graduation_year'     => 'required|digits:4',
            'average_grade'       => 'nullable|numeric|min:0|max:100',
        ]);

        SchoolOrigin::create($data);

        return redirect()->route('student.documents.index')
            ->with('success', 'Data asal sekolah berhasil disimpan!');
    }

    /**
     * Update data asal sekolah
     */
    public function update(Request $request, SchoolOrigin $schoolOrigin)
    {
        // Pastikan data ini milik user yang login
        if ($schoolOrigin->registration->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->validate([
            'school_origin_name' => 'required|string|max:255',
            'graduation_year'    => 'required|digits:4',
            'average_grade'      => 'nullable|numeric|min:0|max:100',
        ]);

        $schoolOrigin->update($data);

        return back()->with('success', 'Data asal sekolah berhasil diupdate!');
    }
}
