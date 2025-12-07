<?php

namespace App\Http\Controllers\Student;

use App\Models\ParentData;
use Illuminate\Http\Request;

class ParentDataController extends Controller
{
    public function store(Request $request)
    {
        return ParentData::create($request->all());
    }

    public function update(Request $request, ParentData $parentData)
    {
        $parentData->update($request->all());
        return $parentData;
    }
}
