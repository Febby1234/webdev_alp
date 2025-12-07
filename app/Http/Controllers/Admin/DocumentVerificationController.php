<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentVerificationController extends Controller
{
    public function index()
    {
        // Ambil semua dokumen yang perlu diverifikasi
        $documents = Document::with('student')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.documents.index', compact('documents'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,verified,rejected',
            'note' => 'nullable|string|max:255',
        ]);

        $document = Document::findOrFail($id);
        $document->status = $request->status;
        $document->note = $request->note;
        $document->save();

        return redirect()->back()->with('success', 'Status dokumen berhasil diperbarui.');
    }
}