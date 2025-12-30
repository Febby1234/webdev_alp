<x-main-layout>
    <x-slot name="title">Jadwal Ujian</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Jadwal Ujian</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Alert Info --}}
            @if($my_schedule)
            <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex">
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="ml-3">
                        <p class="text-sm text-blue-800">
                            <strong>Jadwal Anda:</strong> {{ $my_schedule->type }} - {{ \Carbon\Carbon::parse($my_schedule->date)->format('d F Y') }} pukul {{ \Carbon\Carbon::parse($my_schedule->time)->format('H:i') }} WIB
                        </p>
                    </div>
                </div>
            </div>
            @else
            <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex">
                    <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-800">
                            Jadwal ujian Anda belum tersedia. Silakan hubungi admin untuk informasi lebih lanjut.
                        </p>
                    </div>
                </div>
            </div>
            @endif

            @if($my_schedule)
            {{-- Schedule Card --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Detail Jadwal Ujian Anda</h3>

                    {{-- Header --}}
                    <div class="bg-gradient-to-r from-purple-600 to-purple-700 rounded-lg p-6 text-white mb-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-2xl font-bold">{{ $my_schedule->type }}</h4>
                                <p class="text-purple-100 mt-1">{{ $my_schedule->batch->name ?? 'Gelombang ' . date('Y') }}</p>
                            </div>
                            <svg class="w-16 h-16 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 011-1h4a1 1 0 110 2H8a1 1 0 01-1-1zm0 4a1 1 0 011-1h4a1 1 0 110 2H8a1 1 0 01-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>

                    {{-- Details Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Date --}}
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <label class="text-sm font-medium text-gray-600">Tanggal</label>
                                <p class="text-gray-900 font-semibold mt-1">{{ \Carbon\Carbon::parse($my_schedule->date)->format('d F Y') }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($my_schedule->date)->diffForHumans() }}</p>
                            </div>
                        </div>

                        {{-- Time --}}
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <label class="text-sm font-medium text-gray-600">Waktu</label>
                                <p class="text-gray-900 font-semibold mt-1">{{ \Carbon\Carbon::parse($my_schedule->time)->format('H:i') }} WIB</p>
                                <p class="text-xs text-gray-500 mt-1">Durasi: {{ $my_schedule->duration ?? '90' }} menit</p>
                            </div>
                        </div>

                        {{-- Location --}}
                        <div class="flex items-start md:col-span-2">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <label class="text-sm font-medium text-gray-600">Lokasi</label>
                                <p class="text-gray-900 font-semibold mt-1">{{ $my_schedule->location }}</p>
                                @if($my_schedule->room)
                                <p class="text-sm text-gray-600 mt-1">Ruangan: {{ $my_schedule->room }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Notes --}}
                    @if($my_schedule->notes)
                    <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <div class="flex">
                            <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="ml-3">
                                <h4 class="text-sm font-semibold text-yellow-900">Catatan Penting:</h4>
                                <p class="text-sm text-yellow-800 mt-1">{{ $my_schedule->notes }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Important Notes --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Hal yang Perlu Diperhatikan</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-3 text-gray-700">Hadir 30 menit sebelum ujian dimulai</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-3 text-gray-700">Bawa kartu peserta ujian dan kartu identitas</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-3 text-gray-700">Gunakan pakaian yang sopan dan rapi</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-3 text-gray-700">Siapkan alat tulis (pensil 2B, penghapus, bolpoin)</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-3 text-gray-700">Dilarang membawa HP atau alat komunikasi lainnya</span>
                        </li>
                    </ul>
                </div>
            </div>
            @endif

            {{-- Results Card --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-center">
                    <div class="w-16 h-16 mx-auto bg-purple-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Cek Hasil Ujian</h4>
                    <p class="text-sm text-gray-600 mb-6">Lihat hasil ujian yang sudah Anda ikuti</p>
                    <a href="{{ route('student.exams.results') }}"
                       class="inline-flex items-center px-6 py-3 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition shadow-sm">
                        Lihat Hasil Ujian
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-main-layout>
