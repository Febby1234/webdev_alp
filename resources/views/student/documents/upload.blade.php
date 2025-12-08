<x-main-layout>
    <x-slot name="title">Upload Dokumen</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Upload Dokumen</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <x-back-button href="{{ route('student.documents.index') }}" text="Kembali ke Daftar Dokumen" />

            @php
            $docTypes = [
                'kk_ijazah' => ['title' => 'KK & Ijazah', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'desc' => 'Upload scan KK dan Ijazah/SKL dalam satu file PDF', 'format' => 'PDF', 'max_size' => '2MB'],
                'photo' => ['title' => 'Pas Foto 3x4', 'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z', 'desc' => 'Upload pas foto terbaru dengan background merah', 'format' => 'JPG/PNG', 'max_size' => '1MB'],
                'rapor' => ['title' => 'Rapor Semester 1-5', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'desc' => 'Upload scan rapor semester 1 sampai 5', 'format' => 'PDF', 'max_size' => '5MB']
            ];
            $docType = $docTypes[$type] ?? $docTypes['kk_ijazah'];
            @endphp

            {{-- Document Info --}}
            <x-card class="mb-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $docType['icon'] }}" />
                        </svg>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-xl font-bold text-gray-900">{{ $docType['title'] }}</h3>
                        <p class="text-gray-600 mt-2">{{ $docType['desc'] }}</p>
                        <div class="flex gap-4 mt-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Format: {{ $docType['format'] }}</span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">Max: {{ $docType['max_size'] }}</span>
                        </div>
                    </div>
                </div>
            </x-card>

            {{-- Upload Form --}}
            <x-card title="Upload File">
                <form action="{{ route('student.documents.store') }}" method="POST" enctype="multipart/form-data" id="upload-form">
                    @csrf
                    <input type="hidden" name="type" value="{{ $type }}">

                    <div class="space-y-6">
                        {{-- File Upload --}}
                        <div>
                            <x-input-label for="document" value="Pilih File" class="required" />
                            <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition" id="drop-zone">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="document" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500">
                                            <span>Upload file</span>
                                            <input id="document" name="document" type="file" class="sr-only" accept="{{ $type == 'photo' ? 'image/*' : 'application/pdf' }}" required onchange="handleFileSelect(event)">
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">{{ $docType['format'] }} hingga {{ $docType['max_size'] }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- File Info --}}
                        <div id="file-info" class="hidden p-4 bg-blue-50 rounded-lg border border-blue-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    <div class="ml-3">
                                        <p class="font-semibold text-gray-900" id="file-name"></p>
                                        <p class="text-sm text-gray-600" id="file-size"></p>
                                    </div>
                                </div>
                                <button type="button" onclick="removeFile()" class="text-red-600 hover:text-red-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>
                        </div>

                        {{-- Preview --}}
                        <div id="preview-container" class="hidden">
                            <x-input-label value="Preview" />
                            <div class="mt-2 border rounded-lg p-4 bg-gray-50">
                                <img id="preview-image" src="" alt="Preview" class="max-w-full h-64 mx-auto rounded">
                            </div>
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="w-full px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">✓ Upload Dokumen</button>
                    </div>
                </form>
            </x-card>

        </div>
    </div>

    @push('scripts')
    <script>
        function handleFileSelect(event) {
            const file = event.target.files[0];
            if (!file) return;

            document.getElementById('file-name').textContent = file.name;
            document.getElementById('file-size').textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB';
            document.getElementById('file-info').classList.remove('hidden');

            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                    document.getElementById('preview-container').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }

        function removeFile() {
            document.getElementById('document').value = '';
            document.getElementById('file-info').classList.add('hidden');
            document.getElementById('preview-container').classList.add('hidden');
        }
    </script>
    @endpush
</x-main-layout>
