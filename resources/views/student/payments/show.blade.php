<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Transaksi</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('student.payments.index') }}" class="text-blue-600 hover:underline">
                    &larr; Kembali
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6 border-b pb-4">
                        <h3 class="text-lg font-bold text-gray-900">Invoice #{{ $payment->id }}</h3>
                        <span class="px-3 py-1 rounded-full text-sm font-bold {{ $payment->status == 'verified' ? 'bg-green-100 text-green-800' : ($payment->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ strtoupper($payment->status) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-sm text-gray-500">Tanggal Upload</p>
                            <p class="font-semibold">{{ $payment->created_at->format('d F Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Nominal</p>
                            <p class="font-semibold text-lg">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Bank Pengirim</p>
                            <p class="font-semibold">{{ $payment->bank_account ?? '-' }}</p>
                        </div>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 mb-2">Bukti Transfer:</p>
                        @if($payment->proof_image)
                            <div class="border rounded-lg p-2 bg-gray-50">
                                <img src="{{ asset('storage/' . $payment->proof_image) }}" alt="Bukti Transfer" class="max-w-full h-auto rounded mx-auto max-h-[500px]">
                            </div>
                            <div class="mt-4 text-center">
                                <a href="{{ route('student.payments.download', $payment->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-lg text-sm hover:bg-gray-700">
                                    Download Bukti
                                </a>
                            </div>
                        @else
                            <p class="text-red-500 italic">File bukti tidak ditemukan.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>
