<?php

namespace App\Http\Controllers\Student;

use App\Models\Document;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Tampilkan daftar dokumen yang sudah diupload
     */
    public function index()
    {
        $registration = Registration::where('user_id', Auth::id())->first();

        if (!$registration) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Anda belum melakukan registrasi.');
        }

        $documents = $registration->documents;

        // Daftar tipe dokumen yang diperlukan
        $requiredDocuments = [
            'KTP' => 'Kartu Tanda Penduduk',
            'Ijazah' => 'Ijazah Terakhir',
            'Foto' => 'Pas Foto 3x4',
            'KK' => 'Kartu Keluarga',
        ];

        return view('student.documents.index', compact('documents', 'registration', 'requiredDocuments'));
    }

    /**
     * Upload dokumen
     */
    public function upload(Request $request)
    {
        $data = $request->validate([
            'registration_id' => 'required|exists:registrations,id',
            'type'            => 'required|string|in:KTP,Ijazah,Foto,KK',
            'file'            => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Cek apakah dokumen dengan type ini sudah ada
        $existingDoc = Document::where('registration_id', $data['registration_id'])
            ->where('type', $data['type'])
            ->first();

        if ($existingDoc) {
            return back()->with('error', 'Dokumen ' . $data['type'] . ' sudah diupload sebelumnya. Silakan hapus terlebih dahulu jika ingin mengupload ulang.');
        }

        $path = $request->file('file')->store('documents', 'public');

        $document = Document::create([
            'registration_id' => $data['registration_id'],
            'type'            => $data['type'],
            'file_path'       => $path,
            'status'          => 'pending',
        ]);

        // Update status registrasi jika semua dokumen sudah diupload
        $registration = Registration::find($data['registration_id']);
        $uploadedDocsCount = $registration->documents()->count();

        if ($uploadedDocsCount >= 4 && in_array($registration->status, ['documents_pending', 'pending'])) {
            $registration->update(['status' => 'documents_verified']);
        }

        return back()->with('success', 'Dokumen berhasil diupload!');
    }

    /**
     * Update dokumen (re-upload jika ditolak)
     */
    public function update(Request $request, Document $document)
    {
        // Pastikan dokumen ini milik user yang login
        if ($document->registration->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Hapus file lama
        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        // Upload file baru
        $path = $request->file('file')->store('documents', 'public');

        $document->update([
            'file_path' => $path,
            'status'    => 'pending',
            'note'      => null,
        ]);

        return back()->with('success', 'Dokumen berhasil diupdate!');
    }

    /**
     * Hapus dokumen
     */
    public function destroy(Document $document)
    {
        // Pastikan dokumen ini milik user yang login
        if ($document->registration->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Hapus file dari storage
        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return back()->with('success', 'Dokumen berhasil dihapus!');
    }

    /**
     * Download dokumen
     */
    public function download(Document $document)
    {
        // Pastikan dokumen ini milik user yang login atau admin/interviewer
        $user = Auth::user();
        if ($document->registration->user_id !== $user->id && !in_array($user->role, ['admin', 'interviewer'])) {
            abort(403, 'Unauthorized action.');
        }

        if (!Storage::disk('public')->exists($document->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        $path = Storage::disk('public')->path($document->file_path);

        return response()->download($path);
    }
}
