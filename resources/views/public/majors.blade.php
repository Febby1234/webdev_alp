@extends('layouts.public')

@section('title', 'Program Studi - PPDB ' . date('Y'))

@section('content')
<div class="bg-gradient-to-br from-blue-600 to-blue-800 py-16 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-4">Program Studi Tersedia</h1>
        <p class="text-xl text-blue-100">Pilih jurusan yang sesuai dengan minat dan passion-mu</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    {{-- Filter --}}
    <div class="mb-8 bg-white rounded-lg shadow-sm p-4">
        <div class="flex flex-wrap gap-4 items-center">
            <input type="text"
                   placeholder="Cari jurusan..."
                   class="flex-1 min-w-[200px] px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">Semua Status</option>
                <option value="available">Tersedia</option>
                <option value="full">Penuh</option>
            </select>
        </div>
    </div>

    {{-- Majors Grid --}}
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($majors ?? [] as $major)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
            {{-- Header --}}
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-6 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                <div class="relative">
                    <h3 class="text-2xl font-bold mb-2">{{ $major->name }}</h3>
                    @php
                        $remaining = $major->quota - ($major->registrations_count ?? 0);
                        $percentage = $major->quota > 0 ? (($major->registrations_count ?? 0) / $major->quota) * 100 : 0;
                    @endphp
                    <div class="flex items-center justify-between text-sm">
                        <span>Kuota: {{ $major->quota }}</span>
                        <span class="font-semibold">Sisa: {{ $remaining }}</span>
                    </div>
                    <div class="mt-2 bg-white/20 rounded-full h-2">
                        <div class="bg-white rounded-full h-2 transition-all" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
            </div>

            {{-- Body --}}
            <div class="p-6">
                <div class="mb-4">
                    <h4 class="text-sm font-semibold text-gray-500 uppercase mb-2">Deskripsi</h4>
                    <p class="text-gray-700">
                        {{ $major->description ?? 'Program unggulan dengan fasilitas lengkap, kurikulum modern, dan tenaga pengajar profesional yang siap membimbing menuju masa depan cerah.' }}
                    </p>
                </div>

                <div class="mb-4">
                    <h4 class="text-sm font-semibold text-gray-500 uppercase mb-2">Prospek Karir</h4>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-xs">{{ $major->career_1 ?? 'Professional' }}</span>
                        <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-xs">{{ $major->career_2 ?? 'Entrepreneur' }}</span>
                        <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-xs">{{ $major->career_3 ?? 'Specialist' }}</span>
                    </div>
                </div>

                <div class="mb-6">
                    <h4 class="text-sm font-semibold text-gray-500 uppercase mb-2">Fasilitas</h4>
                    <ul class="space-y-1">
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Laboratorium Modern
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Ruang Praktik Lengkap
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Perpustakaan Digital
                        </li>
                    </ul>
                </div>

                @if($remaining > 0)
                <a href="{{ route('register') }}"
                   class="block w-full text-center px-4 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                    Daftar Sekarang
                </a>
                @else
                <button disabled
                        class="block w-full text-center px-4 py-3 bg-gray-300 text-gray-500 rounded-lg font-semibold cursor-not-allowed">
                    Kuota Penuh
                </button>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-16">
            <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <p class="text-xl text-gray-500">Informasi jurusan akan segera tersedia</p>
        </div>
        @endforelse
    </div>

    {{-- Info Box --}}
    <div class="mt-12 bg-blue-50 border border-blue-200 rounded-xl p-6">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="ml-4">
                <h4 class="text-lg font-semibold text-blue-900 mb-2">Informasi Penting</h4>
                <ul class="text-blue-800 space-y-1">
                    <li>• Setiap pendaftar hanya dapat memilih 1 (satu) jurusan</li>
                    <li>• Kuota dapat berubah sewaktu-waktu</li>
                    <li>• Pendaftaran menggunakan sistem first come first served</li>
                    <li>• Pastikan memilih jurusan sesuai minat dan kemampuan</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
