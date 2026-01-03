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
            return redirect()->route('student.registration.create')
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
     * Tampilkan form upload dokumen
     */
    public function create($type)
    {
        $registration = Registration::where('user_id', Auth::id())->first();

        if (!$registration) {
            return redirect()->route('student.registration.create')
                ->with('error', 'Anda belum melakukan registrasi.');
        }

        // Daftar tipe dokumen yang valid
        $validTypes = ['KTP', 'Ijazah', 'Foto', 'KK'];

        if (!in_array($type, $validTypes)) {
            return redirect()->route('student.documents.index')
                ->with('error', 'Tipe dokumen tidak valid.');
        }

        // Info dokumen berdasarkan type
        $documentTypes = [
            'KTP' => [
                'name' => 'Kartu Tanda Penduduk',
                'description' => 'Upload scan/foto KTP yang masih berlaku',
                'format' => 'jpg,jpeg,png,pdf',
                'max_size' => '2',
            ],
            'Ijazah' => [
                'name' => 'Ijazah Terakhir',
                'description' => 'Upload scan/foto ijazah SMA/SMK/sederajat',
                'format' => 'jpg,jpeg,png,pdf',
                'max_size' => '2',
            ],
            'Foto' => [
                'name' => 'Pas Foto 3x4',
                'description' => 'Upload pas foto terbaru dengan latar belakang merah/biru',
                'format' => 'jpg,jpeg,png',
                'max_size' => '2',
            ],
            'KK' => [
                'name' => 'Kartu Keluarga',
                'description' => 'Upload scan/foto Kartu Keluarga',
                'format' => 'jpg,jpeg,png,pdf',
                'max_size' => '2',
            ],
        ];

        $document_type = (object) $documentTypes[$type];

        return view('student.documents.upload', compact('registration', 'type', 'document_type'));
    }

    /**
     * Simpan dokumen yang diupload
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|string|in:KTP,Ijazah,Foto,KK',
            'document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $registration = Registration::where('user_id', Auth::id())->first();

        if (!$registration) {
            return redirect()->route('student.registration.create')
                ->with('error', 'Anda belum melakukan registrasi.');
        }

        // Cek apakah dokumen dengan type ini sudah ada
        $existingDoc = Document::where('registration_id', $registration->id)
            ->where('type', $data['type'])
            ->first();

        if ($existingDoc) {
            return back()->with('error', 'Dokumen ' . $data['type'] . ' sudah diupload sebelumnya. Silakan hapus terlebih dahulu jika ingin mengupload ulang.');
        }

        $path = $request->file('document')->store('documents', 'public');

        Document::create([
            'registration_id' => $registration->id,
            'type'            => $data['type'],
            'file_path'       => $path,
            'status'          => 'pending',
        ]);

        // Update status registrasi jika semua dokumen sudah diupload
        $uploadedDocsCount = $registration->documents()->count() + 1; // +1 karena baru saja ditambahkan

        if ($uploadedDocsCount >= 4 && in_array($registration->status, ['documents_pending', 'pending'])) {
            $registration->update(['status' => 'documents_verified']);
        }

        return redirect()->route('student.documents.index')
            ->with('success', 'Dokumen berhasil diupload!');
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
