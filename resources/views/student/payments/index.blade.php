<x-main-layout>
    <x-slot name="title">Pembayaran</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pembayaran</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if($latest_payment && $latest_payment->status == 'approved')
                <x-alert type="success"><strong>Pembayaran Terverifikasi!</strong> Pembayaran sudah diverifikasi admin.</x-alert>
            @elseif($latest_payment && $latest_payment->status == 'pending')
                <x-alert type="warning"><strong>Menunggu Verifikasi!</strong> Bukti pembayaran sedang diverifikasi.</x-alert>
            @endif

            {{-- Payment Info --}}
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg shadow-lg p-6 mb-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm opacity-90 mb-1">Total Biaya Pendaftaran</p>
                        <h3 class="text-4xl font-bold">Rp 300.000</h3>
                        <p class="text-sm opacity-90 mt-3">Status Pembayaran</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium mt-1 {{ $latest_payment && $latest_payment->status == 'approved' ? 'bg-green-500' : 'bg-red-500' }}">
                            {{ $latest_payment && $latest_payment->status == 'approved' ? 'Lunas' : 'Belum Bayar' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Upload Button --}}
            @if(!$latest_payment || $latest_payment->status == 'rejected')
            <x-card class="mb-6 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Lakukan Pembayaran</h3>
                <p class="text-gray-600 mb-4">Transfer biaya pendaftaran dan upload bukti pembayaran</p>
                <a href="{{ route('student.payments.show') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">Upload Bukti Transfer →</a>
            </x-card>
            @endif

            {{-- History --}}
            <x-card title="Riwayat Pembayaran">
                @forelse($payments ?? [] as $payment)
                <div class="border-b last:border-0 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                            <p class="text-sm text-gray-600">{{ $payment->created_at->format('d F Y, H:i') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <x-status-badge :status="$payment->status" />
                        <a href="{{ route('student.payments.show', $payment->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Detail →</a>
                    </div>
                </div>
                @empty
                <p class="text-center text-gray-500 py-12">Belum ada riwayat pembayaran</p>
                @endforelse
            </x-card>

        </div>
    </div>
</x-main-layout>
