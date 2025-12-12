<?php

namespace App\Http\Controllers\Student;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'proof' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $path = $request->file('proof')->store('payments', 'public');

        Payment::create([
            'registration_id' => auth()->user()->registration->id,
            'amount' => $request->amount,
            'status' => 'pending',
            'proof_path' => $path
        ]);

        return back()->with('success', 'Payment uploaded successfully.');
    }


    public function verify(Request $request, Payment $payment)
    {
        $payment->update([
            'status'      => $request->status,
            'verified_by' => $request->user()->id
        ]);

        return $payment;
    }
}
