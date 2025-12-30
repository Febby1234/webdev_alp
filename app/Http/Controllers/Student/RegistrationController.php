<?php

namespace App\Http\Controllers\Student;

use App\Models\Registration;
use App\Models\Major;
use App\Models\Batch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    /**
     * Tampilkan form registrasi (Ganti nama dari index ke create)
     */
    public function create()
    {
        // Cek apakah user sudah pernah registrasi
        $registration = Registration::where('user_id', Auth::id())->first();

        if ($registration) {
            // Pastikan route 'student.dashboard' ada di web.php
            return redirect()->route('student.dashboard')
                ->with('info', 'Anda sudah melakukan registrasi sebelumnya.');
        }

        // Ambil major dan batch yang aktif
        $majors = Major::where('is_active', true)->get();
        $batches = Batch::whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->get();

        return view('student.registrations.create', compact('majors', 'batches'));
    }

    /**
     * Simpan registrasi baru
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'major_id' => 'required|exists:majors,id',
            'batch_id' => 'required|exists:batches,id',
        ]);

        $data['user_id'] = Auth::id();

        // Cek apakah user sudah pernah registrasi
        $existingReg = Registration::where('user_id', $data['user_id'])->first();

        if ($existingReg) {
            return back()->with('error', 'Anda sudah melakukan registrasi sebelumnya!');
        }

        // Cek kuota major (hanya hitung registrasi yang aktif/accepted)
        $major = Major::find($data['major_id']);
        $registeredCount = Registration::where('major_id', $data['major_id'])
            ->where('batch_id', $data['batch_id'])
            ->whereIn('status', ['paid', 'exam_scheduled', 'interview_scheduled', 'finished', 'accepted'])
            ->count();

        if ($registeredCount >= $major->quota) {
            return back()->with('error', 'Kuota untuk jurusan ini sudah penuh!');
        }

        // Buat registrasi baru
        $registration = Registration::create($data);

        // PERHATIAN:
        // Di kode Anda sebelumnya tertulis: redirect()->route('student.personal.edit')
        // Tapi di route list Anda adanya: 'student.profile.edit'
        // Saya ubah ke 'student.profile.edit' agar tidak error RouteNotFound nanti.
        // Jika Anda memang punya route 'student.personal.edit', silakan kembalikan.

        return redirect()->route('student.profile.edit')
            ->with('success', 'Registrasi berhasil! Silakan lengkapi data diri Anda. Kode Registrasi: ' . $registration->registration_code);
    }

    /**
     * Tampilkan detail registrasi
     */
    public function show()
    {
        $registration = Registration::where('user_id', Auth::id())
            ->with([
                'user', 'major', 'batch',
                // Pastikan relasi ini ada di Model Registration Anda
                // 'personalDetail', 'parents', 'schoolOrigin',
                'documents', 'payment', 'examResults' //, 'schedules'
            ])
            ->first();

        if (!$registration) {
            // Ini akan memanggil fungsi create() di atas
            return redirect()->route('student.registration.create')
                ->with('error', 'Anda belum melakukan registrasi.');
        }

        return view('student.registration.show', compact('registration'));
    }
}
