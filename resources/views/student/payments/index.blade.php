<x-main-layout>
    <x-slot name="title">Pembayaran</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pembayaran</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if ($latest_payment && $latest_payment->status == 'verified')
                <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex"><svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="ml-3">
                            <p class="text-sm text-green-800">
                                <strong>Pembayaran Terverifikasi!</strong> Pembayaran sudah diverifikasi admin.
                            </p>
                        </div>
                    </div>
                </div>
            @elseif($latest_payment && $latest_payment->status == 'pending')
                <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex"><svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-800"><strong>Menunggu Verifikasi!</strong> Bukti pembayaran
                                sedang diverifikasi.</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg shadow-lg p-8 mb-6 text-white">
                <p class="text-sm opacity-90 mb-2">Total Biaya Pendaftaran</p>
                <h3 class="text-5xl font-bold mb-4">Rp {{ number_format($payment_amount ?? 300000, 0, ',', '.') }}</h3>
                <p class="text-sm opacity-90 mb-2">Status Pembayaran</p>
                <span
                    class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium {{ $latest_payment && $latest_payment->status == 'verified' ? 'bg-green-500' : 'bg-red-500' }}">
                    {{ $latest_payment && $latest_payment->status == 'verified' ? 'Lunas' : 'Belum Bayar' }}
                </span>
            </div>

            @if (!$latest_payment || $latest_payment->status == 'rejected')
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-8 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Lakukan Pembayaran</h3>
                        <p class="text-gray-600 mb-6">Transfer biaya pendaftaran dan upload bukti pembayaran</p>
                        <a href="{{ route('student.payments.show') }}"
                            class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-sm">
                            Upload Bukti Transfer
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Riwayat Pembayaran</h3>
                    @forelse($payments ?? [] as $payment)
                        <div class="border-b last:border-0 py-4 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">Rp
                                        {{ number_format($payment->amount, 0, ',', '.') }}</p>
                                    <p class="text-sm text-gray-600">{{ $payment->created_at->format('d F Y, H:i') }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                @php
                                    $s = $payment->status;
                                    $badges = ['pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'label' => 'Pending'], 'verified' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Verified'], 'rejected' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' => 'Rejected']];
                                    $b = $badges[$s] ?? $badges['pending'];
                                @endphp
                                <span
                                    class="inline-flex px-3 py-1 rounded-full text-xs font-medium {{ $b['bg'] }} {{ $b['text'] }}">{{ $b['label'] }}</span>
                                <a href="{{ route('student.payments.show', $payment->id) }}"
                                    class="text-blue-600 hover:text-blue-800 text-sm font-medium">Detail</a>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-12">Belum ada riwayat pembayaran</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-main-layout>
