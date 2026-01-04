<?php

namespace App\Http\Controllers\Student;

use App\Models\Registration;
use App\Models\Major;
use App\Models\Batch;
use App\Models\PersonalDetail;
use App\Models\ParentData;
use App\Models\SchoolOrigin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function create()
    {
        // Cek user sudah daftar atau belum
        $registration = Registration::where('user_id', Auth::id())->first();

        if ($registration) {
            return redirect()->route('student.dashboard')
                ->with('info', 'Anda sudah melakukan registrasi sebelumnya.');
        }

        $majors = Major::where('is_active', true)->get();
        $batches = Batch::whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->where('is_active', true)
            ->get();

        return view('student.registrations.create', compact('majors', 'batches'));
    }

    public function store(Request $request)
    {
        // 1. VALIDASI DATA INPUT (Sesuai name="" di HTML view)
        $validated = $request->validate([
            // Data Utama
            'major_id' => 'required|exists:majors,id',

            // Biodata
            'fullname'       => 'required|string|max:255',
            'gender'         => 'required|in:L,P', // Validasi input harus L atau P
            'place_of_birth' => 'required|string|max:255',
            'date_of_birth'  => 'required|date',
            'address'        => 'required|string',
            'phone'          => 'required|string|max:20',

            // Orang Tua
            'father_name'   => 'required|string|max:255',
            'father_job'    => 'nullable|string|max:255',
            'father_phone'  => 'nullable|string|max:20',
            'mother_name'   => 'required|string|max:255',
            'mother_job'    => 'nullable|string|max:255',
            'mother_phone'  => 'nullable|string|max:20',

            // Sekolah
            'school_name'     => 'required|string|max:255',
            'graduation_year' => 'required|numeric',
            'average_grade'   => 'nullable|numeric',
        ]);

        // Cek Batch Aktif
        $activeBatch = Batch::whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->where('is_active', true)
            ->first();

        if (!$activeBatch) {
            return back()->with('error', 'Tidak ada gelombang pendaftaran aktif.');
        }

        // Cek Kuota
        $major = Major::find($validated['major_id']);
        if ($major->registrations()->count() >= $major->quota) {
            return back()->with('error', 'Kuota penuh.');
        }

        // 2. MULAI PENYIMPANAN DATA (Transaction)
        try {
            DB::beginTransaction();

            // A. Simpan Registration
            $registration = Registration::create([
                'user_id'  => Auth::id(),
                'major_id' => $validated['major_id'],
                'batch_id' => $activeBatch->id,
                'status'   => 'documents_pending',
            ]);

            // B. Simpan Personal Detail (Mapping Data)
            PersonalDetail::create([
                'registration_id' => $registration->id,

                // Mapping: Input 'fullname' -> DB 'full_name'
                'full_name'       => $validated['fullname'],

                // Konversi Gender: Input 'L'/'P' -> DB 'Laki-laki'/'Perempuan'
                'gender'          => $validated['gender'] == 'L' ? 'Laki-laki' : 'Perempuan',

                // Mapping: Input 'place_of_birth' -> DB 'birth_place'
                'birth_place'     => $validated['place_of_birth'],
                'birth_date'      => $validated['date_of_birth'],
                'address'         => $validated['address'],
                'phone'           => $validated['phone'],
            ]);

            // C. Simpan Parent Data
            ParentData::create([
                'registration_id' => $registration->id,
                'father_name'     => $validated['father_name'],
                'father_job'      => $validated['father_job'],
                'father_phone'    => $validated['father_phone'],
                'mother_name'     => $validated['mother_name'],
                'mother_job'      => $validated['mother_job'],
                'mother_phone'    => $validated['mother_phone'],
            ]);

            // D. Simpan School Origin
            SchoolOrigin::create([
                'registration_id'    => $registration->id,
                'school_origin_name' => $validated['school_name'], // Mapping school_name
                'graduation_year'    => $validated['graduation_year'],
                'average_grade'      => $validated['average_grade'],
            ]);

            DB::commit();

            return redirect()->route('student.documents.index')
                ->with('success', 'Pendaftaran berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage())->withInput();
        }
    }

    public function show()
    {
        $registration = Registration::where('user_id', Auth::id())
            ->with(['user', 'major', 'batch', 'personalDetail', 'documents'])
            ->first();

        if (!$registration) {
            return redirect()->route('student.registration.create');
        }

        return view('student.registrations.show', compact('registration'));
    }
}
