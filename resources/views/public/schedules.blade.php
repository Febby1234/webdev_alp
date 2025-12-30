@extends('layouts.public')

@section('title', 'Jadwal Ujian - PPDB ' . date('Y'))

@section('content')
<div class="bg-gradient-to-br from-orange-600 to-orange-800 py-16 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-4">Jadwal Ujian & Kegiatan</h1>
        <p class="text-xl text-orange-100">Lihat jadwal lengkap ujian seleksi PPDB {{ date('Y') }}</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    {{-- Calendar View --}}
    <div class="bg-white rounded-xl shadow-lg p-8 mb-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Kalender Kegiatan</h2>
        <div class="grid grid-cols-7 gap-2 text-center">
            {{-- Day Headers --}}
            @foreach(['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $day)
            <div class="font-semibold text-gray-600 py-2">{{ $day }}</div>
            @endforeach

            {{-- Calendar Days (simplified) --}}
            @for($i = 1; $i <= 35; $i++)
            <div class="aspect-square border border-gray-200 rounded-lg p-2 hover:bg-blue-50 cursor-pointer transition">
                <div class="text-sm">{{ ($i <= 28) ? $i : '' }}</div>
                @if($i == 15)
                <div class="mt-1">
                    <div class="w-2 h-2 bg-blue-500 rounded-full mx-auto"></div>
                </div>
                @endif
                @if($i == 20)
                <div class="mt-1">
                    <div class="w-2 h-2 bg-red-500 rounded-full mx-auto"></div>
                </div>
                @endif
            </div>
            @endfor
        </div>
        <div class="mt-4 flex flex-wrap gap-4 text-sm">
            <div class="flex items-center">
                <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                <span>Penutupan Pendaftaran</span>
            </div>
            <div class="flex items-center">
                <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                <span>Ujian Seleksi</span>
            </div>
        </div>
    </div>

    {{-- Schedule List --}}
    <div class="grid md:grid-cols-2 gap-8">
        @forelse($schedules ?? [] as $schedule)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition">
            <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold">{{ $schedule->type }}</h3>
                        <p class="text-orange-100 mt-1">{{ \Carbon\Carbon::parse($schedule->date)->format('d F Y') }}</p>
                    </div>
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <div class="text-sm text-gray-500 mb-1">Waktu</div>
                        <div class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($schedule->time)->format('H:i') }} WIB</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500 mb-1">Lokasi</div>
                        <div class="font-semibold text-gray-900">{{ $schedule->location }}</div>
                    </div>
                </div>
                @if($schedule->notes)
                <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                    <p class="text-sm text-orange-800">{{ $schedule->notes }}</p>
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-2 text-center py-16">
            <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-xl text-gray-500">Jadwal akan diumumkan segera</p>
        </div>
        @endforelse
    </div>

    {{-- Important Notes --}}
    <div class="mt-12 bg-yellow-50 border border-yellow-200 rounded-xl p-6">
        <div class="flex">
            <svg class="w-6 h-6 text-yellow-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div class="ml-4">
                <h4 class="text-lg font-semibold text-yellow-900 mb-2">Catatan Penting</h4>
                <ul class="text-yellow-800 space-y-1">
                    <li>• Peserta wajib hadir 30 menit sebelum ujian dimulai</li>
                    <li>• Bawa kartu ujian dan identitas diri (KTP/Kartu Pelajar)</li>
                    <li>• Peserta yang terlambat tidak diperkenankan mengikuti ujian</li>
                    <li>• Informasi lebih lanjut akan dikirim via email dan notifikasi akun</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
