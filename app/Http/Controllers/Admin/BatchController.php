<?php

namespace App\Http\Controllers\Admin;

use App\Models\Batch;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    public function index()
    {
        return Batch::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required',
            'open_date'  => 'required|date',
            'close_date' => 'required|date',
        ]);

        return Batch::create($data);
    }

    public function show(Batch $batch)
    {
        return $batch;
    }

    public function update(Request $request, Batch $batch)
    {
        $batch->update($request->all());
        return $batch;
    }

    public function destroy(Batch $batch)
    {
        $batch->delete();
        return response()->json(['message' => 'Batch deleted']);
    }
}
