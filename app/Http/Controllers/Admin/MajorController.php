<?php

namespace App\Http\Controllers\Admin;

use App\Models\Major;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    public function index()
    {
        return Major::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required',
            'description' => '',
            'quota'       => 'required|integer',
            'is_active'   => 'boolean'
        ]);

        return Major::create($data);
    }

    public function show(Major $major)
    {
        return $major;
    }

    public function update(Request $request, Major $major)
    {
        $major->update($request->all());
        return $major;
    }

    public function destroy(Major $major)
    {
        $major->delete();
        return response()->json(['message' => 'Major deleted']);
    }
}
