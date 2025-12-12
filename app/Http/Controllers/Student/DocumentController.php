<?php

namespace App\Http\Controllers\Student;

use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
   public function upload(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'file' => 'required|mimes:jpg,png,pdf|max:2048'
        ]);

        $path = $request->file('file')->store('documents', 'public');

        Document::create([
            'registration_id' => auth()->user()->registration->id,
            'type' => $request->type,
            'file_path' => $path,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Document uploaded.');
    }

    public function update(Request $request, Document $document)
    {
        $document->update($request->all());
        return $document;
    }
}
