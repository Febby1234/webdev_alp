<x-main-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Gelombang PMB') }}
            </h2>
            <a href="{{ route('admin.batches.create') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Gelombang Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="mb-6">
                    <x-alert type="success">{{ session('success') }}</x-alert>
                </div>
            @endif

            {{-- Active Batch Highlight --}}
            @if(isset($active_batch) && $active_batch)
            <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-lg shadow-lg p-6 mb-6 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-sm font-medium opacity-90">Gelombang Aktif Saat Ini</p>
                        </div>
                        <h3 class="text-2xl font-bold mb-2">{{ $active_batch->batch_name }}</h3>
                        <div class="flex items-center gap-4 text-sm opacity-90">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ \Carbon\Carbon::parse($active_batch->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($active_batch->end_date)->format('d M Y') }}
                            </span>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ \Carbon\Carbon::parse($active_batch->end_date)->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm opacity-90 mb-1">Total Pendaftar</p>
                        <p class="text-4xl font-bold">{{ $active_batch->registrations_count ?? 0 }}</p>
                    </div>
                </div>
            </div>
            @else
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 rounded">
                <div class="flex">
                    <svg class="h-6 w-6 text-yellow-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            <strong class="font-semibold">Perhatian!</strong> Tidak ada gelombang PMB yang aktif saat ini.
                            Calon mahasiswa tidak dapat mendaftar sampai ada gelombang yang diaktifkan.
                        </p>
                    </div>
                </div>
            </div>
            @endif

            {{-- Batches List --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-6 text-gray-900">
                        Semua Gelombang PMB ({{ count($batches ?? []) }})
                    </h3>

                    <div class="space-y-4">
                        @forelse($batches ?? [] as $batch)
                        <div class="border rounded-lg p-6 {{ $batch->is_active ? 'border-green-400 bg-green-50' : 'border-gray-200' }} hover:shadow-md transition">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    {{-- Header --}}
                                    <div class="flex items-center gap-3 mb-4">
                                        <h4 class="text-xl font-bold text-gray-900">{{ $batch->batch_name }}</h4>
                                        @if($batch->is_active)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-600 text-white">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            Aktif
                                        </span>
                                        @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-400 text-white">
                                            Nonaktif
                                        </span>
                                        @endif
                                    </div>

                                    {{-- Info Grid --}}
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                        <div class="flex items-start text-sm">
                                            <svg class="w-5 h-5 mr-2 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <div>
                                                <p class="text-xs text-gray-500 mb-1">Periode Pendaftaran</p>
                                                <p class="font-medium text-gray-900">
                                                    {{ \Carbon\Carbon::parse($batch->start_date)->format('d M Y') }}
                                                </p>
                                                <p class="text-xs text-gray-600">s/d</p>
                                                <p class="font-medium text-gray-900">
                                                    {{ \Carbon\Carbon::parse($batch->end_date)->format('d M Y') }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="flex items-start text-sm">
                                            <svg class="w-5 h-5 mr-2 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            <div>
                                                <p class="text-xs text-gray-500 mb-1">Total Pendaftar</p>
                                                <p class="text-2xl font-bold text-gray-900">{{ $batch->registrations_count ?? 0 }}</p>
                                                <p class="text-xs text-gray-600">Orang</p>
                                            </div>
                                        </div>

                                        <div class="flex items-start text-sm">
                                            <svg class="w-5 h-5 mr-2 text-purple-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <div>
                                                <p class="text-xs text-gray-500 mb-1">Biaya Pendaftaran</p>
                                                <p class="text-lg font-bold text-gray-900">Rp {{ number_format($batch->registration_fee ?? 0, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Status Timeline --}}
                                    <div class="flex items-center gap-2 text-xs">
                                        @php
                                        $now = now();
                                        $start = \Carbon\Carbon::parse($batch->start_date);
                                        $end = \Carbon\Carbon::parse($batch->end_date);
                                        @endphp

                                        @if($now->lt($start))
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded font-medium">Belum Dimulai</span>
                                        <span class="text-gray-500">• Mulai {{ $start->diffForHumans() }}</span>
                                        @elseif($now->between($start, $end))
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded font-medium">Sedang Berjalan</span>
                                        <span class="text-gray-500">• Berakhir {{ $end->diffForHumans() }}</span>
                                        @else
                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded font-medium">Sudah Berakhir</span>
                                        <span class="text-gray-500">• {{ $end->diffForHumans() }}</span>
                                        @endif
                                    </div>

                                    {{-- Description --}}
                                    @if($batch->description)
                                    <div class="mt-3 text-sm text-gray-600">
                                        <p class="line-clamp-2">{{ $batch->description }}</p>
                                    </div>
                                    @endif
                                </div>

                                {{-- Actions --}}
                                <div class="flex flex-col gap-2 ml-6">
                                    @if(!$batch->is_active)
                                    <form method="POST" action="{{ route('admin.batches.toggle', $batch->id) }}">
                                        @csrf
                                        <button type="submit"
                                                class="w-full px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition"
                                                onclick="return confirm('Aktifkan gelombang ini? Gelombang lain akan otomatis dinonaktifkan.')">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Aktifkan
                                        </button>
                                    </form>
                                    @endif

                                    <a href="{{ route('admin.batches.edit', $batch->id) }}"
                                       class="px-4 py-2 bg-blue-600 text-white text-sm font-medium text-center rounded-lg hover:bg-blue-700 transition">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </a>

                                    <a href="{{ route('admin.registrations.index', ['batch_id' => $batch->id]) }}"
                                       class="px-4 py-2 bg-gray-600 text-white text-sm font-medium text-center rounded-lg hover:bg-gray-700 transition">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        Lihat Pendaftar
                                    </a>

                                    @if(!$batch->is_active && ($batch->registrations_count ?? 0) == 0)
                                    <form method="POST" action="{{ route('admin.batches.destroy', $batch->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-full px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition"
                                                onclick="return confirm('Yakin ingin menghapus gelombang ini? Tindakan ini tidak dapat dibatalkan.')">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-gray-500 text-lg mb-4">Belum ada gelombang PMB</p>
                            <a href="{{ route('admin.batches.create') }}"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Buat Gelombang Pertama
                            </a>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-main-layout>
