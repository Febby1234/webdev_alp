<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'registration_id' => 'required',
            'amount'          => 'required|integer',
            'proof'           => 'required|file|mimes:jpg,png,pdf'
        ]);

        $path = $request->file('proof')->store('payments');

        return Payment::create([
            'registration_id' => $data['registration_id'],
            'amount'          => $data['amount'],
            'proof'           => $path,
        ]);
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
