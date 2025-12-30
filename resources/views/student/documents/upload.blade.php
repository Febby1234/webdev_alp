<x-main-layout>
    <x-slot name="title">Upload Dokumen - {{ $document_type->name ?? 'Dokumen' }}</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Upload Dokumen</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- Back Button --}}
            <div class="mb-6">
                <a href="{{ route('student.documents.index') }}"
                   class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Daftar Dokumen
                </a>
            </div>

            {{-- Document Info Card --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="text-xl font-bold text-gray-900">{{ $document_type->name ?? 'Dokumen' }}</h3>
                            <p class="text-gray-600 mt-2">{{ $document_type->description ?? 'Upload dokumen yang diperlukan' }}</p>
                            <div class="flex gap-3 mt-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Format: {{ strtoupper($document_type->format ?? 'PDF') }}
                                </span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    Max: {{ $document_type->max_size ?? '2' }}MB
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Upload Form Card --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Upload File</h3>

                    @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex">
                            <svg class="w-5 h-5 text-red-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <div class="ml-3">
                                <h4 class="text-sm font-semibold text-red-800">Terjadi kesalahan:</h4>
                                <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif

                    <form action="{{ route('student.documents.store') }}" method="POST" enctype="multipart/form-data" id="upload-form">
                        @csrf
                        <input type="hidden" name="type" value="{{ $type ?? 'document' }}">

                        <div class="space-y-6">
                            {{-- File Upload Area --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Pilih File <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition cursor-pointer"
                                     id="drop-zone"
                                     onclick="document.getElementById('document').click()">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="text-sm text-gray-600">
                                            <span class="font-medium text-blue-600 hover:text-blue-500">Upload file</span>
                                            <span class="pl-1">atau drag and drop</span>
                                        </div>
                                        <p class="text-xs text-gray-500">
                                            {{ strtoupper($document_type->format ?? 'PDF') }} hingga {{ $document_type->max_size ?? '2' }}MB
                                        </p>
                                    </div>
                                    <input id="document"
                                           name="document"
                                           type="file"
                                           class="sr-only"
                                           accept="{{ ($document_type->format ?? 'pdf') === 'pdf' ? 'application/pdf' : 'image/*' }}"
                                           required
                                           onchange="handleFileSelect(event)">
                                </div>
                            </div>

                            {{-- File Info Display --}}
                            <div id="file-info" class="hidden p-4 bg-blue-50 rounded-lg border border-blue-200">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center flex-1">
                                        <svg class="w-10 h-10 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <div class="ml-3">
                                            <p class="font-semibold text-gray-900" id="file-name"></p>
                                            <p class="text-sm text-gray-600" id="file-size"></p>
                                        </div>
                                    </div>
                                    <button type="button"
                                            onclick="removeFile()"
                                            class="ml-4 text-red-600 hover:text-red-800 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            {{-- Image Preview --}}
                            <div id="preview-container" class="hidden">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Preview</label>
                                <div class="border rounded-lg p-4 bg-gray-50">
                                    <img id="preview-image" src="" alt="Preview" class="max-w-full max-h-96 mx-auto rounded shadow-sm">
                                </div>
                            </div>

                            {{-- Notes (Optional) --}}
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                    Catatan (Opsional)
                                </label>
                                <textarea id="notes"
                                          name="notes"
                                          rows="3"
                                          class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                            </div>

                            {{-- Submit Button --}}
                            <div class="flex gap-4">
                                <button type="submit"
                                        class="flex-1 inline-flex justify-center items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-sm">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    Upload Dokumen
                                </button>
                                <a href="{{ route('student.documents.index') }}"
                                   class="px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition">
                                    Batal
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Tips Box --}}
            <div class="mt-6 bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex">
                    <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="ml-3">
                        <h4 class="text-sm font-semibold text-green-900 mb-1">Tips Upload Dokumen:</h4>
                        <ul class="text-sm text-green-800 space-y-1">
                            <li>• Pastikan dokumen terlihat jelas dan tidak blur</li>
                            <li>• Gunakan scanner atau foto dengan pencahayaan yang baik</li>
                            <li>• Hindari refleksi atau bayangan pada dokumen</li>
                            <li>• Pastikan seluruh area dokumen terlihat (tidak terpotong)</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        // Drag and drop functionality
        const dropZone = document.getElementById('drop-zone');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.add('border-blue-500', 'bg-blue-50');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.remove('border-blue-500', 'bg-blue-50');
            }, false);
        });

        dropZone.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            document.getElementById('document').files = files;
            handleFileSelect({ target: { files: files } });
        }, false);

        // File selection handler
        function handleFileSelect(event) {
            const file = event.target.files[0];
            if (!file) return;

            // Display file info
            document.getElementById('file-name').textContent = file.name;
            document.getElementById('file-size').textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB';
            document.getElementById('file-info').classList.remove('hidden');

            // Show preview for images
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                    document.getElementById('preview-container').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            } else {
                document.getElementById('preview-container').classList.add('hidden');
            }
        }

        // Remove file
        function removeFile() {
            document.getElementById('document').value = '';
            document.getElementById('file-info').classList.add('hidden');
            document.getElementById('preview-container').classList.add('hidden');
        }

        // Form validation
        document.getElementById('upload-form').addEventListener('submit', function(e) {
            const fileInput = document.getElementById('document');
            if (!fileInput.files.length) {
                e.preventDefault();
                alert('Silakan pilih file terlebih dahulu!');
                return false;
            }
        });
    </script>
</x-main-layout>
