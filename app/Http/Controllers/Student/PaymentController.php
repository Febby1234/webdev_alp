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
        $payment_amount = config('registration.registration_fee');
        $latest_payment = $payment;

        return view('student.payments.index', compact('payment', 'payments', 'registration', 'payment_amount', 'latest_payment'));
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

       $payment_amount = config('registration.registration_fee');

        return view('student.payments.create', compact('registration', 'payment_amount'));
    }

    /**
     * Upload bukti pembayaran
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $data = $request->validate([
            'amount' => 'required|numeric',
            'proof'  => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'bank_account' => 'nullable|string|max:255', // Validasi tetap ada
        ]);

        $registration = Registration::where('user_id', Auth::id())->first();

        if (!$registration) {
            return redirect()->route('student.registration.create')->with('error', 'Belum registrasi');
        }

        // Cek duplicate (biar aman)
        $existingPayment = Payment::where('registration_id', $registration->id)
            ->whereIn('status', ['pending', 'verified'])
            ->first();

        if ($existingPayment) {
            return back()->with('error', 'Anda sedang dalam proses verifikasi.');
        }

        // 2. Simpan File
        $path = $request->file('proof')->store('payments', 'public');

        // 3. Simpan ke Database (INI BAGIAN PENTINGNYA)
        Payment::create([
            'registration_id' => $registration->id,
            'amount'          => $data['amount'],
            'proof_image'     => $path,

            // PERUBAHAN DISINI:
            // Kita simpan input 'bank_account' ke dalam kolom 'note'
            // Karena di database kamu tidak ada kolom 'bank_account'
            'note'            => $request->bank_account,

            'status'          => 'pending',
        ]);

        // 4. Update Status Registrasi
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

    public function show(Payment $payment)
    {
        // Pastikan payment ini milik user yang login
        if ($payment->registration->user_id !== Auth::id()) {
            abort(403);
        }

        return view('student.payments.show', compact('payment'));
    }
}
