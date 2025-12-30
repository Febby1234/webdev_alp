<?php

namespace App\Http\Controllers\Admin;

use App\Models\Schedule;
use App\Models\Registration;
use App\Models\Batch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ScheduleController extends Controller
{
    /**
     * Tampilkan semua jadwal
     */
    public function index()
    {
        $schedules = Schedule::with(['batch', 'registrations'])->latest()->get();
        return view('admin.schedules.index', compact('schedules'));
    }

    /**
     * Form tambah jadwal baru
     */
    public function create()
    {
        $batches = Batch::where('is_active', true)->get();
        return view('admin.schedules.create', compact('batches'));
    }

    /**
     * Buat jadwal baru
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'batch_id' => 'required|exists:batches,id',
            'type'     => 'required|in:exam,interview',
            'date'     => 'required|date',
            'time'     => 'required',
            'location' => 'required|string|max:255',
        ]);

        Schedule::create($data);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil dibuat!');
    }

    /**
     * Tampilkan detail jadwal
     */
    public function show(Schedule $schedule)
    {
        $schedule->load(['batch', 'registrations.user', 'registrations.personalDetail']);
        return view('admin.schedules.show', compact('schedule'));
    }

    /**
     * Form edit jadwal
     */
    public function edit(Schedule $schedule)
    {
        $batches = Batch::all();
        return view('admin.schedules.edit', compact('schedule', 'batches'));
    }

    /**
     * Update jadwal
     */
    public function update(Request $request, Schedule $schedule)
    {
        $data = $request->validate([
            'batch_id' => 'required|exists:batches,id',
            'type'     => 'required|in:exam,interview',
            'date'     => 'required|date',
            'time'     => 'required',
            'location' => 'required|string|max:255',
        ]);

        $schedule->update($data);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil diupdate!');
    }

    /**
     * Hapus jadwal
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil dihapus!');
    }

    /**
     * ASSIGN REGISTRASI KE JADWAL (Many-to-Many)
     * Contoh: Assign banyak siswa ke 1 jadwal ujian
     */
    public function assignRegistrations(Request $request, Schedule $schedule)
    {
        $request->validate([
            'registration_ids'   => 'required|array',
            'registration_ids.*' => 'exists:registrations,id',
        ]);

        // Attach registrations ke schedule (tidak duplicate)
        $schedule->registrations()->syncWithoutDetaching($request->registration_ids);

        return back()->with('success', 'Siswa berhasil ditambahkan ke jadwal!');
    }

    /**
     * REMOVE REGISTRASI DARI JADWAL
     */
    public function removeRegistration(Schedule $schedule, Registration $registration)
    {
        $schedule->registrations()->detach($registration->id);

        return back()->with('success', 'Siswa berhasil dihapus dari jadwal!');
    }

    /**
     * UPDATE ATTENDANCE (kehadiran siswa di jadwal)
     */
    public function updateAttendance(Request $request, Schedule $schedule, Registration $registration)
    {
        $request->validate([
            'attendance' => 'required|boolean',
        ]);

        // Update pivot field 'attendance'
        $schedule->registrations()->updateExistingPivot($registration->id, [
            'attendance' => $request->attendance
        ]);

        return back()->with('success', 'Status kehadiran berhasil diupdate!');
    }

    /**
     * LIHAT DAFTAR SISWA YANG TERDAFTAR DI JADWAL INI
     */
    public function getRegistrations(Schedule $schedule)
    {
        $registrations = $schedule->registrations()
            ->with(['user', 'major', 'personalDetail'])
            ->get();

        return response()->json($registrations);
    }

    /**
     * Form untuk assign siswa ke jadwal
     */
    public function assignForm(Schedule $schedule)
    {
        // Ambil registrasi yang eligible untuk dijadwalkan
        $registrations = Registration::with(['user', 'major', 'personalDetail'])
            ->where('batch_id', $schedule->batch_id)
            ->whereIn('status', ['paid', 'exam_scheduled', 'interview_scheduled'])
            ->whereDoesntHave('schedules', function($query) use ($schedule) {
                $query->where('schedule_id', $schedule->id);
            })
            ->get();

        return view('admin.schedules.assign', compact('schedule', 'registrations'));
    }
}
