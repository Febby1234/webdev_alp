<x-main-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Jurusan') }}
            </h2>
            <a href="{{ route('admin.majors.create') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Jurusan
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-6 text-gray-900">
                        Semua Jurusan ({{ count($majors ?? []) }})
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($majors ?? [] as $major)
                        <div class="border rounded-lg p-6 hover:shadow-lg transition {{ !$major->is_active ? 'bg-gray-50 border-gray-300' : 'border-gray-200' }}">
                            {{-- Header --}}
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $major->name }}</h3>
                                    <p class="text-sm text-gray-600 mt-1 line-clamp-2">
                                        {{ $major->description ?? 'Tidak ada deskripsi' }}
                                    </p>
                                </div>
                                <div class="ml-3 flex-shrink-0">
                                    @if($major->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        Aktif
                                    </span>
                                    @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Nonaktif
                                    </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Quota Progress --}}
                            <div class="mb-4">
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-gray-600 font-medium">Kuota Pendaftar</span>
                                    <span class="font-semibold text-gray-900">
                                        {{ $major->registrations_count ?? 0 }} / {{ $major->quota }}
                                    </span>
                                </div>

                                {{-- Progress Bar --}}
                                @php
                                $percentage = $major->quota > 0 ? (($major->registrations_count ?? 0) / $major->quota) * 100 : 0;
                                $barColor = $percentage >= 90 ? 'bg-red-600' : ($percentage >= 70 ? 'bg-yellow-600' : 'bg-blue-600');
                                @endphp

                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="{{ $barColor }} h-2.5 rounded-full transition-all duration-300"
                                         style="width: {{ min($percentage, 100) }}%">
                                    </div>
                                </div>

                                <p class="text-xs text-gray-500 mt-1">
                                    @if($percentage >= 100)
                                        <span class="text-red-600 font-medium">Kuota penuh!</span>
                                    @elseif($percentage >= 90)
                                        <span class="text-yellow-600 font-medium">Hampir penuh</span>
                                    @else
                                        {{ $major->quota - ($major->registrations_count ?? 0) }} slot tersisa
                                    @endif
                                </p>
                            </div>

                            {{-- Actions --}}
                            <div class="flex flex-col gap-2">
                                {{-- Toggle Active --}}
                                @if(!$major->is_active)
                                <form method="POST" action="{{ route('admin.majors.toggle', $major->id) }}">
                                    @csrf
                                    <button type="submit"
                                            class="w-full inline-flex items-center justify-center px-3 py-2 bg-green-600 text-white text-sm font-medium rounded hover:bg-green-700 transition">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Aktifkan
                                    </button>
                                </form>
                                @else
                                <form method="POST" action="{{ route('admin.majors.toggle', $major->id) }}">
                                    @csrf
                                    <button type="submit"
                                            class="w-full inline-flex items-center justify-center px-3 py-2 bg-gray-400 text-white text-sm font-medium rounded hover:bg-gray-500 transition">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                        </svg>
                                        Nonaktifkan
                                    </button>
                                </form>
                                @endif

                                <div class="flex gap-2">
                                    <a href="{{ route('admin.majors.edit', $major->id) }}"
                                       class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-blue-600 text-white text-sm font-medium text-center rounded hover:bg-blue-700 transition">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </a>

                                    @if(($major->registrations_count ?? 0) == 0)
                                    <form method="POST" action="{{ route('admin.majors.destroy', $major->id) }}" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-full inline-flex items-center justify-center px-3 py-2 bg-red-600 text-white text-sm font-medium rounded hover:bg-red-700 transition"
                                                onclick="return confirm('Yakin ingin menghapus jurusan {{ $major->name }}?')">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                    @else
                                    <button type="button"
                                            disabled
                                            class="flex-1 px-3 py-2 bg-gray-300 text-gray-500 text-sm font-medium rounded cursor-not-allowed"
                                            title="Tidak dapat menghapus jurusan yang sudah memiliki pendaftar">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        Terkunci
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-3 text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <p class="text-gray-500 text-lg mb-4">Belum ada jurusan</p>
                            <a href="{{ route('admin.majors.create') }}"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Tambah Jurusan Pertama
                            </a>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-main-layout>
