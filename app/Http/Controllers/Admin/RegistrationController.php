<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Major;
use App\Models\Batch;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    /**
     * Display a listing of all registrations.
     */
    public function index(Request $request)
    {
        $query = Registration::with(['user', 'major', 'batch']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by major
        if ($request->filled('major_id')) {
            $query->where('major_id', $request->major_id);
        }

        // Filter by batch
        if ($request->filled('batch_id')) {
            $query->where('batch_id', $request->batch_id);
        }

        // Search by student name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $registrations = $query->paginate(15);
        $majors = Major::all();
        $batches = Batch::all();

        return view('admin.registrations.index', compact('registrations', 'majors', 'batches'));
    }

    /**
     * Show the form for creating a new registration.
     */
    public function create()
    {
        $majors = Major::all();
        $batches = Batch::all();
        
        return view('admin.registrations.create', compact('majors', 'batches'));
    }

    /**
     * Store a newly created registration in database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'  => 'required|exists:users,id|unique:registrations,user_id',
            'major_id' => 'required|exists:majors,id',
            'batch_id' => 'required|exists:batches,id',
            'status'   => 'nullable|in:pending,documents_pending,documents_verified,payment_pending,paid,exam_scheduled,interview_scheduled,finished',
        ]);

        try {
            Registration::create($validated);

            return redirect()->route('admin.registrations.index')
                ->with('success', 'Registrasi siswa berhasil dibuat.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat registrasi: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified registration.
     */
    public function show(Registration $registration)
    {
        $registration->load([
            'user',
            'major',
            'batch',
            'personalDetail',
            'parentData',
            'schoolOrigin',
            'documents',
            'payment',
            'examResults'
        ]);

        return view('admin.registrations.show', compact('registration'));
    }

    /**
     * Show the form for editing the specified registration.
     */
    public function edit(Registration $registration)
    {
        $registration->load(['user', 'major', 'batch']);
        $majors = Major::all();
        $batches = Batch::all();

        return view('admin.registrations.edit', compact('registration', 'majors', 'batches'));
    }

    /**
     * Update the specified registration in database.
     */
    public function update(Request $request, Registration $registration)
    {
        $validated = $request->validate([
            'major_id' => 'required|exists:majors,id',
            'batch_id' => 'required|exists:batches,id',
            'status'   => 'required|in:pending,documents_pending,documents_verified,payment_pending,paid,exam_scheduled,interview_scheduled,finished',
        ]);

        try {
            $registration->update($validated);

            return redirect()->route('admin.registrations.show', $registration)
                ->with('success', 'Data registrasi berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui registrasi: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified registration from database.
     */
    public function destroy(Registration $registration)
    {
        try {
            $studentName = $registration->user->name;
            $registration->delete();

            return redirect()->route('admin.registrations.index')
                ->with('success', "Registrasi {$studentName} berhasil dihapus.");
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus registrasi: ' . $e->getMessage());
        }
    }

    /**
     * Bulk update status for multiple registrations.
     */
    public function bulkUpdateStatus(Request $request)
    {
        $validated = $request->validate([
            'registration_ids' => 'required|array',
            'registration_ids.*' => 'exists:registrations,id',
            'status' => 'required|in:pending,documents_pending,documents_verified,payment_pending,paid,exam_scheduled,interview_scheduled,finished',
        ]);

        try {
            Registration::whereIn('id', $validated['registration_ids'])
                ->update(['status' => $validated['status']]);

            return redirect()->route('admin.registrations.index')
                ->with('success', count($validated['registration_ids']) . ' registrasi berhasil diupdate.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal bulk update: ' . $e->getMessage());
        }
    }

    /**
     * Export registrations to Excel.
     */
    public function export(Request $request)
    {
        try {
            $query = Registration::with(['user', 'major', 'batch']);

            // Apply same filters as index
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            if ($request->filled('major_id')) {
                $query->where('major_id', $request->major_id);
            }
            if ($request->filled('batch_id')) {
                $query->where('batch_id', $request->batch_id);
            }

            $registrations = $query->get();

            // Create Excel file using array
            $headers = ['No', 'Nama Siswa', 'Email', 'Jurusan', 'Gelombang', 'Status', 'Tgl Registrasi'];
            $data = [];
            
            foreach ($registrations as $index => $registration) {
                $data[] = [
                    $index + 1,
                    $registration->user->name,
                    $registration->user->email,
                    $registration->major->name,
                    $registration->batch->name,
                    ucfirst(str_replace('_', ' ', $registration->status)),
                    $registration->created_at->format('d/m/Y'),
                ];
            }

            // Prepare CSV content
            $filename = 'registrations_' . date('Y-m-d_His') . '.csv';
            $output = fopen('php://output', 'w');
            
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            
            fputcsv($output, $headers);
            foreach ($data as $row) {
                fputcsv($output, $row);
            }
            fclose($output);
            exit;

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal export: ' . $e->getMessage());
        }
    }
}
