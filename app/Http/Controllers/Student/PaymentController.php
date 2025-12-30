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
            return redirect()->route('student.dashboard')
                ->with('error', 'Anda belum melakukan registrasi.');
        }

        $payment = $registration->payment;

        // Biaya pendaftaran (bisa diambil dari config atau database)
        $registrationFee = 250000; // 250 ribu

        return view('student.payment.index', compact('payment', 'registration', 'registrationFee'));
    }

    /**
     * Upload bukti pembayaran
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'registration_id' => 'required|exists:registrations,id',
            'amount'          => 'required|integer|min:1',
            'proof'           => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Cek apakah sudah ada payment
        $existingPayment = Payment::where('registration_id', $data['registration_id'])->first();

        if ($existingPayment) {
            return back()->with('error', 'Anda sudah mengupload bukti pembayaran sebelumnya.');
        }

        $path = $request->file('proof')->store('payments', 'public');

        $payment = Payment::create([
            'registration_id' => $data['registration_id'],
            'amount'          => $data['amount'],
            'proof_image'     => $path,
            'status'          => 'pending',
        ]);

        // Update status registrasi
        $registration = Registration::find($data['registration_id']);
        $registration->update(['status' => 'payment_pending']);

        return back()->with('success', 'Bukti pembayaran berhasil diupload! Menunggu verifikasi admin.');
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
