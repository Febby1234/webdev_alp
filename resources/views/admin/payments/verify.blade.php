<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Back Button --}}
            <div class="mb-6">
                <a href="{{ route('admin.payments.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Daftar Pembayaran
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Bukti Transfer --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900">Bukti Transfer</h3>
                        @if($payment->proof_image)
                        <img src="{{ asset('storage/' . $payment->proof_image) }}" alt="Bukti Transfer" class="w-full rounded-lg shadow-lg">
                        <a href="{{ asset('storage/' . $payment->proof_image) }}" target="_blank"
                           class="block mt-4 text-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                            Lihat Ukuran Penuh
                        </a>
                        @else
                        <p class="text-gray-500">Tidak ada bukti transfer</p>
                        @endif
                    </div>
                </div>

                {{-- Payment Details --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900">Detail Pembayaran</h3>

                        <div class="space-y-4">
                            <div>
                                <label class="text-sm font-medium text-gray-600">Nama Mahasiswa</label>
                                <p class="text-gray-900 font-semibold">{{ $payment->user->name ?? '-' }}</p>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Email</label>
                                <p class="text-gray-900">{{ $payment->user->email ?? '-' }}</p>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Nominal</label>
                                <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Bank Pengirim</label>
                                <p class="text-gray-900">{{ $payment->bank_account ?? '-' }}</p>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Tanggal Upload</label>
                                <p class="text-gray-900">{{ $payment->created_at->format('d F Y, H:i') }}</p>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600">Status</label>
                                <div class="mt-1">
                                    <x-status-badge :status="$payment->status" class="text-base px-4 py-2" />
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        @if($payment->status == 'pending')
                        <div class="mt-6 space-y-3">
                            <form method="POST" action="{{ route('admin.payments.approve', $payment->payments_id) }}">
                                @csrf
                                <button type="submit" class="w-full px-4 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition">
                                    ✓ Setujui Pembayaran
                                </button>
                            </form>

                            <form method="POST" action="{{ route('admin.payments.reject', $payment->payments_id) }}">
                                @csrf
                                <button type="submit" class="w-full px-4 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition"
                                        onclick="return confirm('Yakin ingin menolak pembayaran ini?')">
                                    ✗ Tolak Pembayaran
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-main-layout>
