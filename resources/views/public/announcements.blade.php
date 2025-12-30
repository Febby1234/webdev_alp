@extends('layouts.public')

@section('title', 'Pengumuman - PPDB ' . date('Y'))

@section('content')
<div class="bg-gradient-to-br from-indigo-600 to-indigo-800 py-16 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-4">Pengumuman</h1>
        <p class="text-xl text-indigo-100">Informasi terbaru seputar PPDB {{ date('Y') }}</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    {{-- Search & Filter --}}
    <div class="mb-8 bg-white rounded-lg shadow-sm p-4">
        <div class="flex flex-wrap gap-4 items-center">
            <input type="text"
                   placeholder="Cari pengumuman..."
                   class="flex-1 min-w-[200px] px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Semua Kategori</option>
                <option value="general">Umum</option>
                <option value="schedule">Jadwal</option>
                <option value="result">Hasil</option>
            </select>
            <button class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                Cari
            </button>
        </div>
    </div>

    {{-- Announcements List --}}
    <div class="space-y-6">
        @forelse($announcements ?? [] as $announcement)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-start flex-1">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $announcement->title }}</h3>
                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>{{ $announcement->created_at->format('d F Y, H:i') }}</span>
                                <span class="mx-2">•</span>
                                <span>{{ $announcement->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="prose max-w-none text-gray-700">
                                {!! nl2br(e($announcement->content)) !!}
                            </div>
                            @if($announcement->attachment)
                            <div class="mt-4 flex items-center">
                                <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                </svg>
                                <a href="{{ $announcement->attachment }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                    Download Lampiran
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div>
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-sm font-medium">
                            {{ ucfirst($announcement->category ?? 'Umum') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-16">
            <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <p class="text-xl text-gray-500 mb-4">Belum ada pengumuman</p>
            <p class="text-gray-400">Pengumuman akan muncul di sini</p>
        </div>
        @endforelse
    </div>

    {{-- Pagination (if needed) --}}
    @if(isset($announcements) && method_exists($announcements, 'links'))
    <div class="mt-8">
        {{ $announcements->links() }}
    </div>
    @endif

    {{-- Subscribe Box --}}
    <div class="mt-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl p-8 text-white">
        <div class="max-w-2xl mx-auto text-center">
            <h3 class="text-2xl font-bold mb-4">Dapatkan Notifikasi Pengumuman Terbaru</h3>
            <p class="text-indigo-100 mb-6">Daftar sekarang dan dapatkan notifikasi langsung via email</p>
            <div class="flex gap-4 max-w-md mx-auto">
                <input type="email"
                       placeholder="email@anda.com"
                       class="flex-1 px-4 py-3 rounded-lg text-gray-900 focus:ring-2 focus:ring-white">
                <button class="px-6 py-3 bg-white text-indigo-600 rounded-lg font-semibold hover:bg-indigo-50 transition">
                    Berlangganan
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
