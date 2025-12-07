<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index()
    {
        return Registration::with(['user','major','batch'])->get();
    }

    public function store(Request $request)
    {
        return Registration::create(
            $request->validate([
                'user_id'  => 'required',
                'major_id' => 'required',
                'batch_id' => 'required'
            ])
        );
    }

    public function show(Registration $registration)
    {
        return $registration->load([
            'user','major','batch',
            'personalDetail','parents','schoolOrigin',
            'documents','payment'
        ]);
    }

    public function update(Request $request, Registration $registration)
    {
        $registration->update($request->all());
        return $registration;
    }

    public function destroy(Registration $registration)
    {
        $registration->delete();
        return response()->json(['message' => 'Registration deleted']);
    }
}
