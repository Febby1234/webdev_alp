<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function upload(Request $request)
    {
        $data = $request->validate([
            'registration_id' => 'required',
            'type'            => 'required',
            'file'            => 'required|file|mimes:jpg,png,pdf'
        ]);

        $path = $request->file('file')->store('documents');

        return Document::create([
            'registration_id' => $data['registration_id'],
            'type'            => $data['type'],
            'file_path'       => $path
        ]);
    }

    public function update(Request $request, Document $document)
    {
        $document->update($request->all());
        return $document;
    }
}
