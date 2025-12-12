<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentVerificationController extends Controller
{
    public function index()
    {
        // Ambil pembayaran terbaru
        $payments = Payment::with('student')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.payments.index', compact('payments'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,verified,rejected',
            'note' => 'nullable|string|max:255',
        ]);

        $payment = Payment::findOrFail($id);
        $payment->status = $request->status;
        $payment->note = $request->note;
        $payment->save();

        return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }
}
