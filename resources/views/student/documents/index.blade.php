<x-main-layout>
    <x-slot name="title">Upload Dokumen</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Upload Dokumen</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Info Alert --}}
            <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex">
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="ml-3">
                        <p class="text-sm text-blue-800">
                            Silahkan upload semua dokumen yang diperlukan. Pastikan dokumen jelas dan sesuai ketentuan.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Progress Card --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Progress Upload</h3>
                        <span class="text-sm text-gray-600">{{ $documents_uploaded ?? 0 }} / {{ $total_documents ?? 5 }} Dokumen</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        @php
                        $percentage = ($total_documents ?? 5) > 0 ? (($documents_uploaded ?? 0) / ($total_documents ?? 5)) * 100 : 0;
                        @endphp
                        <div class="bg-blue-600 h-3 rounded-full transition-all" style="width: {{ $percentage }}%"></div>
                    </div>
                    @if($documents_uploaded >= $total_documents)
                    <div class="mt-4 flex items-center text-green-600">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-semibold">Semua dokumen telah diupload!</span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Documents List --}}
            <div class="space-y-4">
                @forelse($document_requirements ?? [] as $requirement)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center flex-1">
                                <div class="flex-shrink-0">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="ml-4 flex-1">
                                    <h4 class="text-lg font-semibold text-gray-900">{{ $requirement->name }}</h4>
                                    <p class="text-sm text-gray-600 mt-1">{{ $requirement->description }}</p>

                                    @if(isset($requirement->uploaded_document))
                                    <div class="mt-3 flex items-center gap-3">
                                        {{-- Status Badge --}}
                                        @php
                                        $status = $requirement->uploaded_document->status ?? 'pending';
                                        $badges = [
                                            'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'label' => 'Menunggu Verifikasi'],
                                            'verified' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Terverifikasi'],
                                            'rejected' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' => 'Ditolak'],
                                        ];
                                        $badge = $badges[$status] ?? $badges['pending'];
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $badge['bg'] }} {{ $badge['text'] }}">
                                            {{ $badge['label'] }}
                                        </span>

                                        <a href="{{ Storage::url($requirement->uploaded_document->file_path) }}"
                                           target="_blank"
                                           class="text-sm text-blue-600 hover:text-blue-800 font-medium inline-flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Lihat Dokumen
                                        </a>

                                        @if($status === 'rejected' && $requirement->uploaded_document->rejection_reason)
                                        <span class="text-sm text-red-600" title="{{ $requirement->uploaded_document->rejection_reason }}">
                                            Alasan: {{ Str::limit($requirement->uploaded_document->rejection_reason, 30) }}
                                        </span>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Action Button --}}
                            <div class="ml-4">
                                @if(!isset($requirement->uploaded_document) || $requirement->uploaded_document->status === 'rejected')
                                <a href="{{ route('student.documents.upload', ['type' => $requirement->type]) }}"
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    {{ isset($requirement->uploaded_document) ? 'Upload Ulang' : 'Upload' }}
                                </a>
                                @else
                                <button disabled
                                        class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-600 text-sm font-semibold rounded-lg cursor-not-allowed">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Terupload
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-gray-500 text-lg">Belum ada dokumen yang perlu diupload</p>
                    </div>
                </div>
                @endforelse
            </div>

            {{-- Help Box --}}
            <div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                <div class="flex">
                    <svg class="w-6 h-6 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="ml-4">
                        <h4 class="text-lg font-semibold text-yellow-900 mb-2">Catatan Penting</h4>
                        <ul class="text-yellow-800 space-y-1 text-sm">
                            <li>• Pastikan file jelas dan dapat dibaca dengan baik</li>
                            <li>• Upload dalam format yang ditentukan (PDF/JPG/PNG)</li>
                            <li>• Ukuran file tidak melebihi batas maksimal</li>
                            <li>• Dokumen yang ditolak harus diupload ulang</li>
                            <li>• Verifikasi dokumen memakan waktu 1-3 hari kerja</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-main-layout>
