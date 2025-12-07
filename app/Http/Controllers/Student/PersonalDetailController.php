<?php

namespace App\Http\Controllers\Student;

use App\Models\PersonalDetail;
use Illuminate\Http\Request;

class PersonalDetailController extends Controller
{
    public function store(Request $request)
    {
        return PersonalDetail::create(
            $request->validate([
                'registration_id' => 'required',
                'nik'            => 'required',
                'full_name'      => 'required',
                'birth_place'    => 'required',
                'birth_date'     => 'required|date',
                'gender'         => 'required',
                'address'        => 'required'
            ])
        );
    }

    public function update(Request $request, PersonalDetail $detail)
    {
        $detail->update($request->all());
        return $detail;
    }
}