<?php

namespace App\Http\Controllers\Student;

use App\Models\Payment;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Tampilkan halaman pembayaran
     */
    public function index()
    {
        $registration = Registration::where('user_id', Auth::id())->first();

        if (!$registration) {
            return redirect()->route('student.registration.create')
                ->with('error', 'Anda belum melakukan registrasi.');
        }

        $payment = $registration->payment;
        $payments = Payment::where('registration_id', $registration->id)->get();

        // Info pembayaran
        $payment_amount = config('registration.fee', 250000);
        $latest_payment = $payment;

        return view('student.payment.index', compact('payment', 'payments', 'registration', 'payment_amount', 'latest_payment'));
    }

    /**
     * Tampilkan form upload bukti pembayaran
     */
    public function create()
    {
        $registration = Registration::where('user_id', Auth::id())->first();

        if (!$registration) {
            return redirect()->route('student.registration.create')
                ->with('error', 'Anda belum melakukan registrasi.');
        }

        // Cek apakah sudah ada payment yang verified
        $existingPayment = Payment::where('registration_id', $registration->id)
            ->where('status', 'verified')
            ->first();

        if ($existingPayment) {
            return redirect()->route('student.payments.index')
                ->with('info', 'Pembayaran Anda sudah terverifikasi.');
        }

        $payment_amount = config('registration.fee', 250000);

        return view('student.payment.create', compact('registration', 'payment_amount'));
    }

    /**
     * Upload bukti pembayaran
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'amount' => 'required|integer|min:1',
            'proof'  => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $registration = Registration::where('user_id', Auth::id())->first();

        if (!$registration) {
            return redirect()->route('student.registration.create')
                ->with('error', 'Anda belum melakukan registrasi.');
        }

        // Cek apakah sudah ada payment yang pending atau verified
        $existingPayment = Payment::where('registration_id', $registration->id)
            ->whereIn('status', ['pending', 'verified'])
            ->first();

        if ($existingPayment) {
            return back()->with('error', 'Anda sudah mengupload bukti pembayaran sebelumnya.');
        }

        $path = $request->file('proof')->store('payments', 'public');

        Payment::create([
            'registration_id' => $registration->id,
            'amount'          => $data['amount'],
            'proof_image'     => $path,
            'status'          => 'pending',
        ]);

        // Update status registrasi
        $registration->update(['status' => 'payment_pending']);

        return redirect()->route('student.payments.index')
            ->with('success', 'Bukti pembayaran berhasil diupload! Menunggu verifikasi admin.');
    }

    /**
     * Download bukti pembayaran
     */
    public function download(Payment $payment)
    {
        // Pastikan payment ini milik user yang login atau admin
        $user = Auth::user();
        if ($payment->registration->user_id !== $user->id && $user->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        if (!Storage::disk('public')->exists($payment->proof_image)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        $path = Storage::disk('public')->path($payment->proof_image);
        return response()->download($path);
    }
}
