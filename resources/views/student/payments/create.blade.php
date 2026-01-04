<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Upload Bukti Pembayaran</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('student.payments.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Daftar Pembayaran
                </a>
            </div>

            {{-- Bagian Info Rekening --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900">Rekening Tujuan Transfer</h3>
                    <div class="space-y-4">
                        {{-- BCA --}}
                        <div class="p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg border-2 border-blue-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-14 h-14 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-lg shadow-lg">BCA</div>
                                    <div class="ml-4">
                                        <p class="text-sm text-gray-600 mb-1">Bank Central Asia</p>
                                        <p class="text-2xl font-bold text-gray-900 tracking-wide">1234567890</p>
                                        <p class="text-sm text-gray-700 mt-1">a.n. <strong>Universitas XYZ</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- BNI --}}
                        <div class="p-4 bg-gradient-to-r from-red-50 to-red-100 rounded-lg border-2 border-red-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-14 h-14 bg-red-600 rounded-lg flex items-center justify-center text-white font-bold text-lg shadow-lg">BNI</div>
                                    <div class="ml-4">
                                        <p class="text-sm text-gray-600 mb-1">Bank Negara Indonesia</p>
                                        <p class="text-2xl font-bold text-gray-900 tracking-wide">0987654321</p>
                                        <p class="text-sm text-gray-700 mt-1">a.n. <strong>Universitas XYZ</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bagian Total & Form --}}
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg shadow-lg p-6 mb-6 text-white text-center">
                <p class="text-sm opacity-90 mb-2">Total yang harus dibayar</p>
                <h3 class="text-5xl font-bold mb-3">Rp {{ number_format($payment_amount ?? 300000, 0, ',', '.') }}</h3>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Form Upload Bukti</h3>
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                            <ul class="text-sm text-red-700 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('student.payments.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        {{-- Nominal Hidden --}}
                        <input type="hidden" name="amount" value="{{ $payment_amount ?? 300000 }}">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Transfer dari Bank/Rekening (Opsional)</label>
                            <input type="text" name="bank_account" placeholder="Contoh: BCA a.n. Budi" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Bukti Transfer <span class="text-red-500">*</span></label>
                            <input type="file" name="proof" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" accept="image/*,application/pdf" required>
                        </div>

                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                            <p class="text-sm text-yellow-700"><strong>Penting:</strong> Pastikan bukti transfer terlihat jelas.</p>
                        </div>

                        <button type="submit" class="w-full px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-lg">
                            Kirim Bukti Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>
