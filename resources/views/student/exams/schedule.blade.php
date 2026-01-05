<x-main-layout>
    <x-slot name="title">Jadwal Ujian & Seleksi</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jadwal Ujian & Seleksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- 1. INFO GELOMBANG (Agar siswa tau kenapa dia dapat jadwal ini) --}}
            <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            Status Pendaftaran: <strong>{{ $registration->batch->batch_name ?? 'Gelombang Umum' }}</strong>.
                            <br>Berikut adalah jadwal kegiatan untuk gelombang Anda.
                        </p>
                    </div>
                </div>
            </div>

            {{-- 2. LOOPING JADWAL (Menggunakan $schedules dari Controller) --}}
            <div class="space-y-6 mb-8">
                @forelse($schedules as $schedule)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 hover:shadow-md transition duration-200">
                        <div class="p-6">
                            <div class="flex flex-col md:flex-row md:items-start md:justify-between">

                                {{-- KIRI: Detail Informasi --}}
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-3">
                                        {{-- Badge Tipe --}}
                                        <span class="px-3 py-1 text-xs font-bold rounded-full uppercase tracking-wide
                                            {{ $schedule->type == 'exam' ? 'bg-purple-100 text-purple-700' : 'bg-green-100 text-green-700' }}">
                                            {{ $schedule->type == 'exam' ? 'Ujian Tertulis' : 'Wawancara' }}
                                        </span>
                                        {{-- Waktu Relative --}}
                                        <span class="text-xs text-gray-500 flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ \Carbon\Carbon::parse($schedule->date)->diffForHumans() }}
                                        </span>
                                    </div>

                                    {{-- Tanggal Besar --}}
                                    <h3 class="text-xl font-bold text-gray-900">
                                        {{ \Carbon\Carbon::parse($schedule->date)->translatedFormat('l, d F Y') }}
                                    </h3>

                                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                        {{-- Waktu --}}
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center">
                                                <svg class="h-4 w-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">Waktu</p>
                                                <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($schedule->time)->format('H:i') }} WIB</p>
                                            </div>
                                        </div>

                                        {{-- Lokasi --}}
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center">
                                                <svg class="h-4 w-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">Lokasi</p>
                                                <p class="text-sm text-gray-600">
                                                    {{ $schedule->location }}
                                                    @if($schedule->room) <span class="block text-xs text-gray-500">Ruang: {{ $schedule->room }}</span> @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    @if($schedule->notes)
                                        <div class="mt-4 bg-yellow-50 border border-yellow-100 rounded p-3">
                                            <p class="text-xs text-yellow-800"><strong>Catatan:</strong> {{ $schedule->notes }}</p>
                                        </div>
                                    @endif
                                </div>

                                {{-- KANAN: Tombol Aksi --}}
                                <div class="mt-6 md:mt-0 md:ml-6 flex-shrink-0">
                                    @if($schedule->type == 'exam')
                                        <a href="{{ route('student.exams.print_card') }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 active:bg-purple-900 focus:outline-none focus:border-purple-900 focus:ring ring-purple-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-md">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                            Cetak Kartu Ujian
                                        </a>
                                    @else
                                        <span class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-500 uppercase tracking-widest cursor-default">
                                            Wawancara
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- 3. EMPTY STATE (Jika Jadwal Kosong) --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-12 text-center border-2 border-dashed border-gray-300">
                        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-gray-100 mb-4">
                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Belum Ada Jadwal</h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Saat ini belum ada jadwal ujian yang dirilis untuk <strong>{{ $registration->batch->batch_name ?? 'Gelombang Anda' }}</strong>.
                            <br>Silakan cek kembali secara berkala.
                        </p>
                    </div>
                @endforelse
            </div>

            {{-- 4. RULES (Tetap ditampilkan sebagai info tambahan) --}}
            @if($schedules->isNotEmpty())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tata Tertib Ujian</h3>
                    <ul class="space-y-3 text-sm text-gray-600">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Hadir 30 menit sebelum ujian dimulai.
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Wajib membawa Kartu Peserta Ujian (Cetak dari tombol di atas).
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Berpakaian sopan dan rapi (Kemeja/Berkerah).
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Dilarang membawa alat komunikasi ke dalam ruang ujian.
                        </li>
                    </ul>
                </div>
            </div>
            @endif

            {{-- Tombol Hasil Ujian --}}
            <div class="mt-6 flex justify-end">
                 <a href="{{ route('student.exams.results') }}" class="text-sm text-purple-600 hover:text-purple-800 font-semibold flex items-center">
                    Cek Hasil Ujian &rarr;
                </a>
            </div>

        </div>
    </div>
</x-main-layout>
