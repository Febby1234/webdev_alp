<?php

namespace App\Http\Controllers\Student;

use App\Models\PersonalDetail;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PersonalDetailController extends Controller
{
    /**
     * Tampilkan form edit data personal
     */
    public function edit()
    {
        $registration = Registration::where('user_id', Auth::id())->first();

        if (!$registration) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Anda belum melakukan registrasi.');
        }

        $detail = $registration->personalDetail;

        return view('student.personal-detail.edit', compact('detail', 'registration'));
    }

    /**
     * Simpan data personal
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'registration_id' => 'required|exists:registrations,id',
            'full_name'       => 'required|string|max:255',
            'birth_place'     => 'required|string|max:255',
            'birth_date'      => 'required|date',
            'gender'          => 'required|in:Laki-laki,Perempuan',
            'address'         => 'required|string',
            'phone'           => 'nullable|string|max:20',
        ]);

        $detail = PersonalDetail::create($data);

        // Update status registrasi
        $registration = Registration::find($data['registration_id']);
        if ($registration->status === 'pending') {
            $registration->update(['status' => 'documents_pending']);
        }

        return redirect()->route('student.parents.edit')
            ->with('success', 'Data personal berhasil disimpan!');
    }

    /**
     * Update data personal
     */
    public function update(Request $request, PersonalDetail $detail)
    {
        // Pastikan detail ini milik user yang login
        if ($detail->registration->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->validate([
            'full_name'   => 'required|string|max:255',
            'birth_place' => 'required|string|max:255',
            'birth_date'  => 'required|date',
            'gender'      => 'required|in:Laki-laki,Perempuan',
            'address'     => 'required|string',
            'phone'       => 'nullable|string|max:20',
        ]);

        $detail->update($data);

        return back()->with('success', 'Data personal berhasil diupdate!');
    }
}
