<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi Dokumen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Filter --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" class="flex gap-4">
                        <select name="status" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Verified</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Filter
                        </button>
                    </form>
                </div>
            </div>

            {{-- Documents Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($documents ?? [] as $document)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        {{-- Header --}}
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-semibold text-gray-900">{{ $document->type }}</p>
                                    <p class="text-xs text-gray-600">{{ $document->user->name ?? '-' }}</p>
                                </div>
                            </div>
                            <x-status-badge :status="$document->status" />
                        </div>

                        {{-- Preview --}}
                        <div class="mb-4">
                            @if(str_contains($document->file_path, '.pdf'))
                            <div class="h-48 bg-gray-100 rounded-lg flex items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            @else
                            <img src="{{ asset('storage/' . $document->file_path) }}" alt="Preview" class="h-48 w-full object-cover rounded-lg">
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="mb-4">
                            <p class="text-sm text-gray-600">Filename:</p>
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $document->document_name }}</p>
                            <p class="text-xs text-gray-500 mt-1">Upload: {{ $document->created_at->format('d M Y, H:i') }}</p>
                        </div>

                        {{-- Actions --}}
                        <div class="flex gap-2">
                            <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank"
                               class="flex-1 px-3 py-2 bg-gray-600 text-white text-sm text-center rounded hover:bg-gray-700 transition">
                                Lihat
                            </a>
                            @if($document->status == 'pending')
                            <form method="POST" action="{{ route('admin.documents.approve', $document->document_id) }}" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full px-3 py-2 bg-green-600 text-white text-sm rounded hover:bg-green-700 transition">
                                    ✓ Verify
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.documents.reject', $document->document_id) }}">
                                @csrf
                                <button type="submit" class="px-3 py-2 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition"
                                        onclick="return confirm('Yakin tolak dokumen ini?')">
                                    ✗
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-3 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-gray-500">Tidak ada dokumen untuk diverifikasi</p>
                    </div>
                </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($documents && $documents->hasPages())
            <div class="mt-6">
                {{ $documents->links() }}
            </div>
            @endif

        </div>
    </div>
</x-main-layout>
