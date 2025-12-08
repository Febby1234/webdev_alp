<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Back Button --}}
            <div class="mb-6">
                <a href="{{ route('student.payments.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Daftar Pembayaran
                </a>
            </div>

            {{-- Rekening Tujuan --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900">Rekening Tujuan Transfer</h3>

                    <div class="space-y-4">
                        <div class="p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg border-2 border-blue-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-14 h-14 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                        BCA
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm text-gray-600 mb-1">Bank Central Asia</p>
                                        <p class="text-2xl font-bold text-gray-900 tracking-wide">1234567890</p>
                                        <p class="text-sm text-gray-700 mt-1">a.n. <strong>Universitas XYZ</strong></p>
                                    </div>
                                </div>
                                <button onclick="copyToClipboard('1234567890')" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition shadow">
                                    📋 Copy
                                </button>
                            </div>
                        </div>

                        <div class="p-4 bg-gradient-to-r from-red-50 to-red-100 rounded-lg border-2 border-red-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-14 h-14 bg-red-600 rounded-lg flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                        BNI
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm text-gray-600 mb-1">Bank Negara Indonesia</p>
                                        <p class="text-2xl font-bold text-gray-900 tracking-wide">0987654321</p>
                                        <p class="text-sm text-gray-700 mt-1">a.n. <strong>Universitas XYZ</strong></p>
                                    </div>
                                </div>
                                <button onclick="copyToClipboard('0987654321')" class="px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition shadow">
                                    📋 Copy
                                </button>
                            </div>
                        </div>

                        <div class="p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-lg border-2 border-green-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-14 h-14 bg-green-600 rounded-lg flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                        BRI
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm text-gray-600 mb-1">Bank Rakyat Indonesia</p>
                                        <p class="text-2xl font-bold text-gray-900 tracking-wide">5566778899</p>
                                        <p class="text-sm text-gray-700 mt-1">a.n. <strong>Universitas XYZ</strong></p>
                                    </div>
                                </div>
                                <button onclick="copyToClipboard('5566778899')" class="px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 transition shadow">
                                    📋 Copy
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Nominal Pembayaran --}}
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg shadow-lg p-6 mb-6 text-white">
                <div class="text-center">
                    <p class="text-sm opacity-90 mb-2">Total yang harus dibayar</p>
                    <h3 class="text-5xl font-bold mb-3">Rp 300.000</h3>
                    <button onclick="copyToClipboard('300000')" class="px-4 py-2 bg-white text-orange-600 rounded-lg font-semibold hover:bg-orange-50 transition">
                        Copy Nominal
                    </button>
                </div>
            </div>

            {{-- Upload Form --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-6 text-gray-900">Upload Bukti Transfer</h3>

                    <form action="{{ route('student.payments.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="amount" :value="__('Nominal Transfer')" />
                            <x-text-input id="amount" class="block mt-1 w-full text-lg font-bold" type="number" name="amount" value="300000" readonly />
                            <p class="text-sm text-gray-500 mt-1">⚠️ Transfer sesuai nominal yang tertera</p>
                        </div>

                        <div>
                            <x-input-label for="bank_account" :value="__('Transfer dari Bank/Rekening')" />
                            <x-text-input id="bank_account" class="block mt-1 w-full" type="text" name="bank_account" placeholder="Contoh: BCA - 1234567890 a.n. Budi Santoso" />
                            <p class="text-sm text-gray-500 mt-1">Opsional: Untuk mempermudah proses verifikasi</p>
                        </div>

                        <div>
                            <x-input-label for="proof_image" :value="__('Bukti Transfer (Screenshot/Foto)')" class="required" />
                            <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="proof_image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500">
                                            <span>Upload file</span>
                                            <input id="proof_image" name="proof_image" type="file" class="sr-only" accept="image/*" required onchange="previewImage(event)">
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, JPEG sampai 2MB</p>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('proof_image')" class="mt-2" />

                            {{-- Image Preview --}}
                            <div id="image-preview" class="mt-4 hidden">
                                <img id="preview-img" src="" alt="Preview" class="max-w-full h-64 rounded-lg shadow-lg mx-auto">
                            </div>
                        </div>

                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                            <div class="flex">
                                <svg class="h-5 w-5 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        <strong>Penting:</strong> Pastikan bukti transfer dapat terbaca dengan jelas (nominal, tanggal, nama penerima)
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-lg">
                                ✓ Upload Bukti Transfer
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Panduan --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h4 class="font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Panduan Pembayaran
                    </h4>
                    <ol class="text-sm text-gray-700 space-y-3 list-decimal list-inside">
                        <li class="pl-2">Salin nomor rekening dengan menekan tombol <strong>"Copy"</strong></li>
                        <li class="pl-2">Transfer sesuai <strong>nominal yang tertera</strong> ke salah satu rekening</li>
                        <li class="pl-2">Simpan bukti transfer dari bank (screenshot/foto)</li>
                        <li class="pl-2">Upload bukti transfer yang <strong>jelas dan dapat terbaca</strong></li>
                        <li class="pl-2">Tunggu verifikasi dari admin (maksimal 1x24 jam kerja)</li>
                        <li class="pl-2">Cek status pembayaran secara berkala</li>
                    </ol>

                    <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <div class="ml-3">
                                <p class="text-sm text-blue-800">
                                    <strong>Butuh bantuan?</strong><br>
                                    Hubungi Admin PMB:<br>
                                    📞 <strong>0812-3456-7890</strong><br>
                                    📧 <strong>pmb@universitasxyz.ac.id</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Show success message
                const message = document.createElement('div');
                message.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                message.textContent = '✓ Berhasil disalin!';
                document.body.appendChild(message);

                setTimeout(() => {
                    message.remove();
                }, 2000);
            }, function(err) {
                console.error('Gagal menyalin: ', err);
                alert('Gagal menyalin. Silakan copy manual.');
            });
        }

        function previewImage(event) {
            const preview = document.getElementById('image-preview');
            const previewImg = document.getElementById('preview-img');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
    @endpush
</x-main-layout>
