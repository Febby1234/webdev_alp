<x-main-layout>
    <x-slot name="title">Jadwal Ujian</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Jadwal Ujian</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if($my_schedule)
                <x-alert type="info">
                    <strong>Jadwal Anda:</strong> {{ $my_schedule->type }} - {{ date('d F Y', strtotime($my_schedule->date)) }} pukul {{ date('H:i', strtotime($my_schedule->time)) }} WIB
                </x-alert>
            @else
                <x-alert type="warning">Jadwal ujian Anda belum tersedia.</x-alert>
            @endif

            @if($my_schedule)
            <x-card title="Detail Jadwal Ujian Anda" class="mb-6">
                <div class="bg-gradient-to-r from-purple-600 to-purple-700 rounded-lg p-6 text-white mb-6">
                    <h4 class="text-2xl font-bold">{{ $my_schedule->type }}</h4>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-blue-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        <div class="ml-3"><label class="text-sm font-medium text-gray-600">Tanggal</label><p class="text-gray-900 font-semibold">{{ date('d F Y', strtotime($my_schedule->date)) }}</p></div>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-blue-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <div class="ml-3"><label class="text-sm font-medium text-gray-600">Waktu</label><p class="text-gray-900 font-semibold">{{ date('H:i', strtotime($my_schedule->time)) }} WIB</p></div>
                    </div>
                    <div class="flex items-start md:col-span-2">
                        <svg class="w-6 h-6 text-blue-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /></svg>
                        <div class="ml-3"><label class="text-sm font-medium text-gray-600">Lokasi</label><p class="text-gray-900 font-semibold">{{ $my_schedule->location }}</p></div>
                    </div>
                </div>
            </x-card>
            @endif

            <x-card class="text-center">
                <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <h4 class="font-semibold text-gray-900 mb-2">Cek Hasil Ujian</h4>
                <p class="text-sm text-gray-600 mb-4">Lihat hasil ujian yang sudah Anda ikuti</p>
                <a href="{{ route('student.exams.results') }}" class="inline-flex items-center px-5 py-2 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition">Lihat Hasil Ujian →</a>
            </x-card>

        </div>
    </div>
</x-main-layout>
