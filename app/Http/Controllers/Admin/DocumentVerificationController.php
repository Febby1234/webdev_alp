<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentVerificationController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::with(['registration.user', 'registration.major', 'registration.personalDetail']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Search by name
        if ($request->filled('search')) {
            $query->whereHas('registration.user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })->orWhereHas('registration.personalDetail', function ($q) use ($request) {
                $q->where('full_name', 'like', '%' . $request->search . '%');
            });
        }

        $documents = $query->latest()->paginate(20);

        // Stats untuk quick filter
        $stats = [
            'pending'  => Document::where('status', 'pending')->count(),
            'verified' => Document::where('status', 'verified')->count(),
            'rejected' => Document::where('status', 'rejected')->count(),
        ];

        // Required documents dari config
        $requiredDocuments = config('registration.required_documents', []);

        return view('admin.documents.index', compact('documents', 'stats', 'requiredDocuments'));
    }

    /**
     * Tampilkan detail dokumen
     */
    public function show(Document $document)
    {
        $document->load(['registration.user', 'registration.major', 'registration.personalDetail']);

        return view('admin.documents.show', compact('document'));
    }

    /**
     * Tampilkan dokumen berdasarkan status
     */
    public function byStatus($status)
    {
        $documents = Document::with(['registration.user', 'registration.major', 'registration.personalDetail'])
            ->where('status', $status)
            ->latest()
            ->paginate(20);

        $stats = [
            'pending'  => Document::where('status', 'pending')->count(),
            'verified' => Document::where('status', 'verified')->count(),
            'rejected' => Document::where('status', 'rejected')->count(),
        ];

        return view('admin.documents.index', compact('documents', 'status', 'stats'));
    }

    /**
     * Verifikasi atau tolak dokumen (unified update method)
     */
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'status' => 'required|in:pending,verified,rejected',
        ]);

        $document->status = $request->status;
        $document->save();

        // Jika semua dokumen sudah verified, update status registrasi
        if ($request->status === 'verified') {
            $this->checkAndUpdateRegistrationStatus($document->registration);
        }

        return redirect()->back()
            ->with('success', 'Status dokumen berhasil diperbarui.');
    }

    /**
     * Verifikasi semua dokumen satu registrasi sekaligus
     */
    public function verifyAll(Registration $registration)
    {
        $registration->documents()->update([
            'status' => 'verified',
        ]);

        $this->checkAndUpdateRegistrationStatus($registration);

        return back()->with('success', 'Semua dokumen berhasil diverifikasi!');
    }

    /**
     * Download dokumen
     */
    public function download(Document $document)
    {
        if (!Storage::disk('public')->exists($document->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        $path = Storage::disk('public')->path($document->file_path);
        return response()->download($path);
    }

    /**
     * Cek apakah semua dokumen wajib sudah verified
     * dan update status registrasi jika sudah lengkap
     */
    protected function checkAndUpdateRegistrationStatus(Registration $registration): void
    {
        // Ambil jumlah minimum dokumen dari config
        $requiredDocuments = config('registration.required_documents', []);
        $minimumDocuments = count($requiredDocuments);

        // Fallback ke 4 jika config kosong
        if ($minimumDocuments === 0) {
            $minimumDocuments = 4;
        }

        // Cek apakah semua dokumen sudah verified
        $totalDocs = $registration->documents()->count();
        $verifiedDocs = $registration->documents()->where('status', 'verified')->count();

        $allVerified = $totalDocs > 0 && $totalDocs === $verifiedDocs;

        // Update status jika dokumen sudah lengkap dan semua verified
        if ($allVerified && $totalDocs >= $minimumDocuments) {
            $registration->update(['status' => 'payment_pending']);
        }
    }
}
