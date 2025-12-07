<?php

namespace App\Http\Controllers;

use App\Models\SchoolOrigin;
use Illuminate\Http\Request;

class SchoolOriginController extends Controller
{
    public function store(Request $request)
    {
        return SchoolOrigin::create($request->all());
    }

    public function update(Request $request, SchoolOrigin $schoolOrigin)
    {
        $schoolOrigin->update($request->all());
        return $schoolOrigin;
    }
}
