<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentVerificationController extends Controller
{
    public function index()
    {
        // Ambil pembayaran terbaru
        $payments = Payment::with(['registration.user', 'registration.major'])
            ->latest()
            ->paginate(20);

        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Tampilkan payment berdasarkan status
     */
    public function byStatus($status)
    {
        $payments = Payment::with(['registration.user', 'registration.major'])
            ->where('status', $status)
            ->latest()
            ->paginate(20);

        return view('admin.payments.index', compact('payments', 'status'));
    }

    /**
     * Verifikasi atau tolak pembayaran
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,verified,rejected', // FIXED: changed 'approved' to 'verified'
            'note'   => 'nullable|string|max:255',
        ]);

        $payment = Payment::findOrFail($id);
        $payment->status = $request->status;
        $payment->note = $request->note ?? null;
        $payment->verified_by = Auth::id();
        $payment->save();

        // Update status registrasi
        $registration = $payment->registration;

        if ($request->status === 'verified') {
            $registration->update(['status' => 'paid']);
        } elseif ($request->status === 'rejected') {
            $registration->update(['status' => 'payment_pending']);
        }

        return redirect()->back()
            ->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    /**
     * Download bukti pembayaran
     */
    public function download(Payment $payment)
    {
        if (!Storage::disk('public')->exists($payment->proof_image)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        $path = Storage::disk('public')->path($payment->proof_image); 
        return response()->download($path);
    }
}
