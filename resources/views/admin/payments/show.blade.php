<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            {{-- Back Button --}}
            <div class="mb-6">
                <a href="{{ route('admin.payments.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Daftar Pembayaran
                </a>
            </div>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="mb-6">
                    <x-alert type="success">{{ session('success') }}</x-alert>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Bukti Transfer --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Bukti Transfer</h3>
                            <x-status-badge :status="$payment->status" />
                        </div>

                        @if($payment->proof_image)
                        <div class="space-y-4">
                            <img src="{{ Storage::url($payment->proof_image) }}"
                                 alt="Bukti Transfer"
                                 class="w-full rounded-lg shadow-lg border border-gray-200"
                                 onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 fill=%27none%27 viewBox=%270 0 24 24%27 stroke=%27%23ccc%27%3E%3Cpath stroke-linecap=%27round%27 stroke-linejoin=%27round%27 stroke-width=%272%27 d=%27M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z%27/%3E%3C/svg%3E'">

                            <a href="{{ Storage::url($payment->proof_image) }}"
                               target="_blank"
                               class="flex items-center justify-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Lihat/Unduh Bukti Transfer
                            </a>
                        </div>
                        @else
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-gray-500">Tidak ada bukti transfer</p>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Payment Details --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900">Detail Pembayaran</h3>

                        <div class="space-y-4">
                            {{-- Student Info --}}
                            <div class="pb-4 border-b border-gray-200">
                                <label class="text-xs font-medium text-gray-500 uppercase">Pendaftar</label>
                                <p class="text-lg font-semibold text-gray-900 mt-1">
                                    {{ $payment->registration->personalDetail->full_name ?? $payment->registration->user->name ?? '-' }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    {{ $payment->registration->registration_code ?? '-' }}
                                </p>
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase">Email</label>
                                <p class="text-gray-900 mt-1">{{ $payment->registration->user->email ?? '-' }}</p>
                            </div>

                            {{-- Amount --}}
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase">Nominal Pembayaran</label>
                                <p class="text-3xl font-bold text-gray-900 mt-1">
                                    Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                </p>
                            </div>

                            {{-- Batch --}}
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase">Batch Pendaftaran</label>
                                <p class="text-gray-900 mt-1">{{ $payment->registration->batch->name ?? '-' }}</p>
                            </div>

                            {{-- Upload Date --}}
                            <div>
                                <label class="text-xs font-medium text-gray-500 uppercase">Tanggal Upload Bukti</label>
                                <p class="text-gray-900 mt-1">{{ $payment->created_at->format('d F Y, H:i') }}</p>
                            </div>

                            {{-- Verified Info --}}
                            @if($payment->status === 'verified')
                            <div class="pt-4 border-t border-gray-200">
                                <label class="text-xs font-medium text-gray-500 uppercase">Diverifikasi</label>
                                <p class="text-gray-900 mt-1">
                                    {{ $payment->updated_at->format('d F Y, H:i') }}
                                </p>
                                @if($payment->verifiedBy)
                                <p class="text-sm text-gray-600">
                                    oleh {{ $payment->verifiedBy->name }}
                                </p>
                                @endif
                            </div>
                            @endif
                        </div>

                        {{-- Actions --}}
                        @if($payment->status == 'pending')
                        <div class="mt-6 space-y-3 pt-6 border-t border-gray-200">
                            <form method="POST" action="{{ route('admin.payments.update', $payment->id) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="verified">
                                <button type="submit"
                                        class="w-full inline-flex items-center justify-center px-4 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Setujui Pembayaran
                                </button>
                            </form>

                            <form method="POST"
                                  action="{{ route('admin.payments.update', $payment->id) }}"
                                  onsubmit="return confirm('Yakin ingin menolak pembayaran ini?')">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit"
                                        class="w-full inline-flex items-center justify-center px-4 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Tolak Pembayaran
                                </button>
                            </form>
                        </div>
                        @elseif($payment->status == 'verified')
                        <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex">
                                <svg class="h-5 w-5 text-green-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="ml-3 text-sm text-green-700">
                                    Pembayaran telah disetujui
                                </p>
                            </div>
                        </div>
                        @elseif($payment->status == 'rejected')
                        <div class="mt-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                            <div class="flex">
                                <svg class="h-5 w-5 text-red-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="ml-3 text-sm text-red-700">
                                    Pembayaran telah ditolak
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-main-layout>
