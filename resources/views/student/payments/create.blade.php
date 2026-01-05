<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($payment) ? 'Update Bukti Pembayaran' : 'Upload Bukti Pembayaran' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            {{-- Tombol Kembali --}}
            <div class="mb-6">
                <a href="{{ route('student.payments.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                    <-- Kembali ke Daftar Pembayaran
                </a>
            </div>

            {{-- ALERT JIKA DITOLAK --}}
            @if(isset($payment) && $payment->status == 'rejected')
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4">
                <div class="flex">
                    <div class="flex-shrink-0"><svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg></div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">
                            <strong>Pembayaran Ditolak:</strong> {{ $payment->rejection_reason ?? 'Bukti tidak valid' }}. Silakan upload ulang.
                        </p>
                    </div>
                </div>
            </div>
            @endif

            {{-- === BAGIAN INFO REKENING (YANG HILANG TADI) === --}}
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

            {{-- === TOTAL BAYAR === --}}
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg shadow-lg p-6 mb-6 text-white text-center">
                <p class="text-sm opacity-90 mb-2">Total yang harus dibayar</p>
                <h3 class="text-5xl font-bold mb-3">Rp {{ number_format($payment_amount ?? 300000, 0, ',', '.') }}</h3>
            </div>

            {{-- === FORM UPLOAD (DENGAN PREVIEW) === --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">
                        {{ isset($payment) ? 'Form Update Bukti' : 'Form Upload Bukti' }}
                    </h3>

                    <form action="{{ route('student.payments.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        {{-- Kirim nominal (hidden) --}}
                        <input type="hidden" name="amount" value="{{ $payment_amount ?? 300000 }}">

                        {{-- Input Bank --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Bank Pengirim (Opsional)</label>
                            <input type="text" name="bank_account"
                                   value="{{ old('bank_account', $payment->note ?? '') }}"
                                   placeholder="Contoh: BCA a.n. Budi"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        {{-- Input File & Preview --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Bukti Transfer <span class="text-red-500">*</span></label>

                            {{-- AREA PREVIEW GAMBAR --}}
                            <div class="mb-4">
                                {{-- 1. Jika User sudah pernah upload, tampilkan gambar lama --}}
                                @if(isset($payment) && $payment->proof_image)
                                    <img id="img-preview" src="{{ Storage::url($payment->proof_image) }}"
                                         class="w-full max-w-sm rounded-lg border border-gray-300 shadow-sm object-cover"
                                         style="max-height: 300px;">
                                    <p id="preview-text" class="text-xs text-gray-500 mt-1">Gambar saat ini. Pilih file baru untuk mengganti.</p>

                                {{-- 2. Jika Belum upload, siapkan img kosong (hidden) --}}
                                @else
                                    <img id="img-preview" class="hidden w-full max-w-sm rounded-lg border border-gray-300 shadow-sm object-cover"
                                         style="max-height: 300px;">
                                @endif
                            </div>

                            <input type="file" id="proof" name="proof"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                   accept="image/*,application/pdf" required onchange="previewImage()">
                        </div>

                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                            <p class="text-sm text-yellow-700"><strong>Penting:</strong> Pastikan bukti transfer terlihat jelas.</p>
                        </div>

                        <button type="submit" class="w-full px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-lg">
                            {{ isset($payment) ? 'Update Bukti Pembayaran' : 'Kirim Bukti Pembayaran' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPT JAVASCRIPT UNTUK PREVIEW --}}
    @push('scripts')
    <script>
        function previewImage() {
            const image = document.querySelector('#proof');
            const imgPreview = document.querySelector('#img-preview');
            const previewText = document.querySelector('#preview-text');

            // Cek apakah ada file yang dipilih
            if (image.files && image.files[0]) {
                const oFReader = new FileReader();
                oFReader.readAsDataURL(image.files[0]);

                oFReader.onload = function(oFREvent) {
                    // Ganti source gambar dengan file yang baru dipilih
                    imgPreview.src = oFREvent.target.result;
                    // Pastikan gambar muncul (hapus class hidden)
                    imgPreview.classList.remove('hidden');

                    // Update teks keterangan (opsional)
                    if(previewText) {
                        previewText.textContent = "Preview gambar yang akan diupload.";
                    }
                }
            }
        }
    </script>
    @endpush
</x-main-layout>
