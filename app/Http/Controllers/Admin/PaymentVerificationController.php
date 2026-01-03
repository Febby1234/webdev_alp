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
    public function index(Request $request)
    {
        $query = Payment::with(['registration.user', 'registration.major', 'registration.personalDetail']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by name
        if ($request->filled('search')) {
            $query->whereHas('registration.user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })->orWhereHas('registration.personalDetail', function ($q) use ($request) {
                $q->where('full_name', 'like', '%' . $request->search . '%');
            });
        }

        $payments = $query->latest()->paginate(20);

        // Stats untuk quick filter
        $stats = [
            'pending'  => Payment::where('status', 'pending')->count(),
            'verified' => Payment::where('status', 'verified')->count(),
            'rejected' => Payment::where('status', 'rejected')->count(),
        ];

        return view('admin.payments.index', compact('payments', 'stats'));
    }

    /**
     * Tampilkan detail pembayaran
     */
    public function show(Payment $payment)
    {
        $payment->load(['registration.user', 'registration.major', 'registration.personalDetail', 'registration.batch', 'verifiedBy']);

        return view('admin.payments.show', compact('payment'));
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

        $stats = [
            'pending'  => Payment::where('status', 'pending')->count(),
            'verified' => Payment::where('status', 'verified')->count(),
            'rejected' => Payment::where('status', 'rejected')->count(),
        ];

        return view('admin.payments.index', compact('payments', 'status', 'stats'));
    }

    /**
     * Verifikasi atau tolak pembayaran (unified update method)
     */
    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:pending,verified,rejected',
        ]);

        $payment->status = $request->status;
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
