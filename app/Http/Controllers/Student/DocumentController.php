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

        // Ambil dokumen yang sudah diupload user, keyBy type agar mudah dicari
        $uploadedDocuments = $registration->documents->keyBy('type');

        // Definisi Persyaratan Dokumen (Samakan dengan method create)
        $definitions = [
            'KTP' => [
                'name' => 'Kartu Tanda Penduduk',
                'description' => 'Upload scan/foto KTP yang masih berlaku',
            ],
            'Ijazah' => [
                'name' => 'Ijazah Terakhir',
                'description' => 'Upload scan/foto ijazah SMA/SMK/sederajat',
            ],
            'Foto' => [
                'name' => 'Pas Foto 3x4',
                'description' => 'Upload pas foto terbaru latar belakang merah/biru',
            ],
            'KK' => [
                'name' => 'Kartu Keluarga',
                'description' => 'Upload scan/foto Kartu Keluarga',
            ],
        ];

        // Susun data agar sesuai dengan permintaan View (index.blade.php)
        $document_requirements = [];
        foreach ($definitions as $type => $info) {
            $req = new \stdClass();
            $req->type = $type;
            $req->name = $info['name'];
            $req->description = $info['description'];
            // Pasangkan dengan dokumen yang sudah diupload (jika ada)
            $req->uploaded_document = $uploadedDocuments[$type] ?? null;

            $document_requirements[] = $req;
        }

        // Data untuk progress bar
        $total_documents = count($definitions);
        $documents_uploaded = $uploadedDocuments->count();

        return view('student.documents.index', compact(
            'document_requirements',
            'registration',
            'total_documents',
            'documents_uploaded'
        ));
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

        // Cek apakah dokumen tipe ini sudah ada sebelumnya
        $existingDoc = Document::where('registration_id', $registration->id)
            ->where('type', $data['type'])
            ->first();

        // Jika ada dokumen lama, hapus file fisiknya biar storage gak penuh
        if ($existingDoc && Storage::disk('public')->exists($existingDoc->file_path)) {
            Storage::disk('public')->delete($existingDoc->file_path);
        }

        // Upload file baru
        $file = $request->file('document');
        $path = $file->store('documents', 'public');

        // Update atau Create data di database
        // Jika sudah ada (update), status reset jadi pending & rejection_reason dihapus
        // Jika belum ada (create), buat baru status pending
        Document::updateOrCreate(
            [
                'registration_id' => $registration->id,
                'type' => $data['type']
            ],
            [
                'document_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'status' => 'pending', // Reset status jadi pending setiap kali upload baru
                'rejection_reason' => null // Hapus alasan penolakan lama
            ]
        );

        // Cek kelengkapan dokumen (Opsional: Update status registrasi jika semua lengkap)
        // Logika ini bisa disesuaikan dengan kebutuhan bisnis
        /*
        $uploadedDocsCount = $registration->documents()->count();
        if ($uploadedDocsCount >= 4 && $registration->status == 'documents_pending') {
             // $registration->update(['status' => 'documents_uploaded']);
        }
        */

        return redirect()->route('student.documents.index')
            ->with('success', 'Dokumen berhasil diupload!');
    }

    /**
     * Update dokumen (re-upload jika ditolak)
     */
    public function update(Request $request, Document $document)
    {
        if ($document->registration->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->validate([
            'document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // Ganti 'file' jadi 'document' biar konsisten sama form view upload.blade.php jika pakai form yang sama
        ]);

        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $path = $request->file('document')->store('documents', 'public');

        $document->update([
            'file_path' => $path,
            'status'    => 'pending', // Reset jadi pending agar admin cek ulang
        ]);

        return redirect()->route('student.documents.index')->with('success', 'Dokumen berhasil diupdate!');
    }

    /**
     * Hapus dokumen
     */
    public function destroy(Document $document)
    {
        if ($document->registration->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return back()->with('success', 'Dokumen berhasil dihapus!');
    }

    /**
     * Download dokumen
     */
/**
     * Download dokumen
     */
    public function download(Document $document)
    {
        $user = Auth::user();
        // Pastikan dokumen milik user login ATAU user adalah admin/interviewer
        if ($document->registration->user_id !== $user->id && !in_array($user->role, ['admin', 'interviewer'])) {
            abort(403, 'Unauthorized action.');
        }

        // Cek keberadaan file
        if (!Storage::disk('public')->exists($document->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        // Ambil full path dari storage
        $path = Storage::disk('public')->path($document->file_path);

        // Return download response
        return response()->download($path);
    }
}
