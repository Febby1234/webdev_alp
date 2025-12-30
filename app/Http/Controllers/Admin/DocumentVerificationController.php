<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentVerificationController extends Controller
{
    public function index()
    {
        // Ambil semua dokumen yang perlu diverifikasi
        $documents = Document::with(['registration.user', 'registration.major', 'registration.personalDetail'])
            ->latest()
            ->paginate(20);

        return view('admin.documents.index', compact('documents'));
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

        return view('admin.documents.index', compact('documents', 'status'));
    }

    /**
     * Verifikasi atau tolak dokumen
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,verified,rejected',
            'note'   => 'nullable|string|max:255',
        ]);

        $document = Document::findOrFail($id);
        $document->status = $request->status;
        $document->note = $request->note;
        $document->save();

        // Jika semua dokumen sudah verified, update status registrasi
        if ($request->status === 'verified') {
            $registration = $document->registration;
            $allVerified = $registration->documents()
                ->where('status', '!=', 'verified')
                ->count() === 0;

            if ($allVerified && $registration->documents()->count() >= 4) {
                $registration->update(['status' => 'payment_pending']);
            }
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
            'note' => null
        ]);

        $registration->update(['status' => 'payment_pending']);

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
}
