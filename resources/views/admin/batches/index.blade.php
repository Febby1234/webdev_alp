<x-main-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Gelombang PMB') }}</h2>
            <a href="{{ route('admin.batches.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                + Buat Gelombang Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Active Batch Info --}}
            @if($active_batch)
            <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-lg shadow-lg p-6 mb-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm opacity-90 mb-1">Gelombang Aktif Saat Ini</p>
                        <h3 class="text-2xl font-bold">{{ $active_batch->batch_name }}</h3>
                        <p class="text-sm opacity-90 mt-2">
                            {{ date('d F Y', strtotime($active_batch->start_date)) }} - {{ date('d F Y', strtotime($active_batch->end_date)) }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm opacity-90">Total Pendaftar</p>
                        <p class="text-3xl font-bold">{{ $active_batch->registrations_count ?? 0 }}</p>
                    </div>
                </div>
            </div>
            @else
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                <div class="flex">
                    <svg class="h-6 w-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            <strong>Perhatian!</strong> Tidak ada gelombang PMB yang aktif saat ini. Silakan buat gelombang baru.
                        </p>
                    </div>
                </div>
            </div>
            @endif

            {{-- Batches List --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-6 text-gray-900">Semua Gelombang PMB</h3>

                    <div class="space-y-4">
                        @forelse($batches ?? [] as $batch)
                        <div class="border rounded-lg p-6 {{ $batch->is_active ? 'border-green-400 bg-green-50' : 'border-gray-200' }} hover:shadow-md transition">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-3">
                                        <h4 class="text-xl font-bold text-gray-900">{{ $batch->batch_name }}</h4>
                                        @if($batch->is_active)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-600 text-white">
                                            Aktif
                                        </span>
                                        @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-400 text-white">
                                            Nonaktif
                                        </span>
                                        @endif
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <div>
                                                <p class="text-xs text-gray-500">Periode Pendaftaran</p>
                                                <p class="font-medium text-gray-900">
                                                    {{ date('d M Y', strtotime($batch->start_date)) }} - {{ date('d M Y', strtotime($batch->end_date)) }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            <div>
                                                <p class="text-xs text-gray-500">Total Pendaftar</p>
                                                <p class="font-medium text-gray-900">{{ $batch->registrations_count ?? 0 }} Orang</p>
                                            </div>
                                        </div>

                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <div>
                                                <p class="text-xs text-gray-500">Biaya Pendaftaran</p>
                                                <p class="font-medium text-gray-900">Rp {{ number_format($batch->registration_fee ?? 0, 0, ',', '.') }}</p>
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
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded">Belum Dimulai</span>
                                        <span class="text-gray-500">Mulai {{ $start->diffForHumans() }}</span>
                                        @elseif($now->between($start, $end))
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded">Sedang Berjalan</span>
                                        <span class="text-gray-500">Berakhir {{ $end->diffForHumans() }}</span>
                                        @else
                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded">Sudah Berakhir</span>
                                        <span class="text-gray-500">{{ $end->diffForHumans() }}</span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Actions --}}
                                <div class="flex flex-col gap-2 ml-6">
                                    @if(!$batch->is_active)
                                    <form method="POST" action="{{ route('admin.batches.activate', $batch->batch_id) }}">
                                        @csrf
                                        <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition"
                                                onclick="return confirm('Aktifkan gelombang ini? Gelombang lain akan otomatis dinonaktifkan.')">
                                            Aktifkan
                                        </button>
                                    </form>
                                    @endif

                                    <a href="{{ route('admin.batches.edit', $batch->batch_id) }}"
                                       class="px-4 py-2 bg-blue-600 text-white text-sm text-center rounded-lg hover:bg-blue-700 transition">
                                        Edit
                                    </a>

                                    <a href="{{ route('admin.registrations.index', ['batch_id' => $batch->batch_id]) }}"
                                       class="px-4 py-2 bg-gray-600 text-white text-sm text-center rounded-lg hover:bg-gray-700 transition">
                                        Lihat Pendaftar
                                    </a>

                                    @if(!$batch->is_active && ($batch->registrations_count ?? 0) == 0)
                                    <form method="POST" action="{{ route('admin.batches.destroy', $batch->batch_id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition"
                                                onclick="return confirm('Hapus gelombang ini?')">
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
                            <p class="text-gray-500">Belum ada gelombang PMB</p>
                            <a href="{{ route('admin.batches.create') }}" class="inline-block mt-4 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
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
