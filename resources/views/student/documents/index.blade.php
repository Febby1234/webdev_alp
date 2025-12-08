<x-main-layout>
    <x-slot name="title">Upload Dokumen</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Upload Dokumen</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <x-alert type="info">
                Silahkan upload semua dokumen yang diperlukan. Pastikan dokumen jelas dan sesuai ketentuan.
            </x-alert>

            {{-- Progress --}}
            <x-card class="mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Progress Upload</h3>
                    <span class="text-sm text-gray-600">{{ $documents_uploaded ?? 0 }} / {{ $total_documents ?? 5 }} Dokumen</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-blue-600 h-3 rounded-full transition-all" style="width: {{ (($documents_uploaded ?? 0) / ($total_documents ?? 5)) * 100 }}%"></div>
                </div>
            </x-card>

            {{-- Documents List --}}
            <div class="space-y-4">
                @foreach([
                    ['type' => 'kk_ijazah', 'title' => 'KK & Ijazah', 'format' => 'PDF, max 2MB', 'status' => $document_kk ?? null],
                    ['type' => 'photo', 'title' => 'Pas Foto 3x4', 'format' => 'JPG/PNG, max 1MB', 'status' => $document_photo ?? null],
                    ['type' => 'rapor', 'title' => 'Rapor Semester 1-5', 'format' => 'PDF, max 5MB', 'status' => $document_rapor ?? null]
                ] as $doc)
                <x-card>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center flex-1">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">{{ $doc['title'] }}</h4>
                                <p class="text-sm text-gray-600 mt-1">{{ $doc['format'] }}</p>
                                @if($doc['status'])
                                <div class="mt-2 flex items-center gap-2">
                                    <x-status-badge :status="$doc['status']->status ?? 'unverified'" />
                                    <a href="{{ route('student.documents.view', $doc['status']->id) }}" class="text-sm text-blue-600">Lihat</a>
                                </div>
                                @endif
                            </div>
                        </div>
                        @if(!$doc['status'] || $doc['status']->status == 'rejected')
                        <a href="{{ route('student.documents.upload', ['type' => $doc['type']]) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Upload</a>
                        @else
                        <button disabled class="px-4 py-2 bg-gray-300 text-gray-600 rounded-lg cursor-not-allowed">Terupload</button>
                        @endif
                    </div>
                </x-card>
                @endforeach
            </div>

        </div>
    </div>
</x-main-layout>
