<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi Dokumen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="mb-6">
                    <x-alert type="success">{{ session('success') }}</x-alert>
                </div>
            @endif

            {{-- Filter & Stats --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">
                                Total Dokumen: {{ $documents->total() ?? count($documents ?? []) }}
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">
                                Filter dokumen berdasarkan status verifikasi
                            </p>
                        </div>

                        {{-- Quick Stats --}}
                        <div class="flex gap-4 text-sm">
                            <div class="text-center">
                                <p class="text-gray-600">Pending</p>
                                <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] ?? 0 }}</p>
                            </div>
                            <div class="text-center">
                                <p class="text-gray-600">Verified</p>
                                <p class="text-2xl font-bold text-green-600">{{ $stats['verified'] ?? 0 }}</p>
                            </div>
                            <div class="text-center">
                                <p class="text-gray-600">Rejected</p>
                                <p class="text-2xl font-bold text-red-600">{{ $stats['rejected'] ?? 0 }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Filter Form --}}
                    <form method="GET" class="flex flex-wrap gap-3">
                        <select name="status" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Verified</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>

                        <select name="type" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                            <option value="">Semua Jenis Dokumen</option>
                            <option value="KTP" {{ request('type') == 'KTP' ? 'selected' : '' }}>KTP</option>
                            <option value="Ijazah" {{ request('type') == 'Ijazah' ? 'selected' : '' }}>Ijazah</option>
                            <option value="Kartu Keluarga" {{ request('type') == 'Kartu Keluarga' ? 'selected' : '' }}>Kartu Keluarga</option>
                            <option value="Pas Foto" {{ request('type') == 'Pas Foto' ? 'selected' : '' }}>Pas Foto</option>
                        </select>

                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Cari nama pendaftar..."
                               class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">

                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            Filter
                        </button>

                        @if(request()->hasAny(['status', 'type', 'search']))
                        <a href="{{ route('admin.documents.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Reset
                        </a>
                        @endif
                    </form>
                </div>
            </div>

            {{-- Documents Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($documents ?? [] as $document)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition">
                    <div class="p-6">
                        {{-- Header --}}
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-start flex-1">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="text-sm font-semibold text-gray-900">{{ $document->type }}</p>
                                    <p class="text-xs text-gray-600">
                                        {{ $document->registration->personalDetail->full_name ?? $document->registration->user->name ?? 'Unknown' }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $document->registration->registration_code ?? '-' }}
                                    </p>
                                </div>
                            </div>
                            <x-status-badge :status="$document->status" />
                        </div>

                        {{-- Preview --}}
                        <div class="mb-4">
                            @if(Str::endsWith($document->file_path, '.pdf'))
                            <div class="h-48 bg-gray-100 rounded-lg flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                                <p class="text-sm text-gray-500">PDF Document</p>
                            </div>
                            @else
                            <img src="{{ Storage::url($document->file_path) }}"
                                 alt="Preview {{ $document->type }}"
                                 class="h-48 w-full object-cover rounded-lg"
                                 onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 fill=%27none%27 viewBox=%270 0 24 24%27 stroke=%27%23ccc%27%3E%3Cpath stroke-linecap=%27round%27 stroke-linejoin=%27round%27 stroke-width=%272%27 d=%27M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z%27/%3E%3C/svg%3E'">
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="mb-4 space-y-1">
                            <div class="flex items-center text-xs text-gray-500">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Upload: {{ $document->created_at->format('d M Y, H:i') }}
                            </div>
                            @if($document->verified_at)
                            <div class="flex items-center text-xs text-green-600">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Verified: {{ $document->verified_at->format('d M Y, H:i') }}
                            </div>
                            @endif
                        </div>

                        {{-- Actions --}}
                        <div class="flex gap-2">
                            {{-- View Document --}}
                            <a href="{{ Storage::url($document->file_path) }}"
                               target="_blank"
                               class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-gray-600 text-white text-sm rounded hover:bg-gray-700 transition">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Lihat
                            </a>

                            {{-- Verify/Reject Buttons --}}
                            @if($document->status == 'pending')
                            <form method="POST"
                                  action="{{ route('admin.documents.update', $document->id) }}"
                                  class="flex-1">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="verified">
                                <button type="submit"
                                        class="w-full inline-flex items-center justify-center px-3 py-2 bg-green-600 text-white text-sm rounded hover:bg-green-700 transition">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Verify
                                </button>
                            </form>

                            <form method="POST"
                                  action="{{ route('admin.documents.update', $document->id) }}"
                                  onsubmit="return confirm('Yakin ingin menolak dokumen ini?')">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit"
                                        class="px-3 py-2 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
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
                        <p class="text-gray-500 text-lg mb-2">Tidak ada dokumen untuk diverifikasi</p>
                        <p class="text-gray-400 text-sm">
                            @if(request()->hasAny(['status', 'type', 'search']))
                                Coba ubah filter atau <a href="{{ route('admin.documents.index') }}" class="text-blue-600 hover:underline">reset pencarian</a>
                            @else
                                Dokumen akan muncul di sini ketika ada pendaftar yang mengupload dokumen
                            @endif
                        </p>
                    </div>
                </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if(isset($documents) && method_exists($documents, 'links'))
                <div class="mt-6">
                    {{ $documents->appends(request()->query())->links() }}
                </div>
            @endif

        </div>
    </div>
</x-main-layout>
