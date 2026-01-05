<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Interviewer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Welcome Banner --}}
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg shadow-lg p-6 mb-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold">Selamat Datang, {{ auth()->user()->name }}!</h3>
                        <p class="text-blue-100 mt-1">Panel Interviewer PMB {{ date('Y') }}</p>
                    </div>
                </div>
            </div>

            {{-- Statistics Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                {{-- Total Peserta --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-600">Total Peserta</p>
                                <h3 class="text-2xl font-bold text-gray-900">{{ $total_participants ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Belum Diinterview --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-600">Belum Diinterview</p>
                                <h3 class="text-2xl font-bold text-gray-900">{{ $pending_interviews ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sudah Diinterview --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-600">Sudah Diinterview</p>
                                <h3 class="text-2xl font-bold text-gray-900">{{ $completed_interviews ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Jadwal Hari Ini --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-600">Jadwal Hari Ini</p>
                                <h3 class="text-2xl font-bold text-gray-900">{{ $today_schedules ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-2 gap-6">


                {{-- Peserta Belum Diinterview --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900">Peserta Menunggu Interview</h3>

                        <div class="space-y-3">
                            @forelse($pending_participants ?? [] as $participant)
                                <div
                                    class="flex items-center justify-between p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                                    <div class="flex items-center">
                                        <div class="ml-3">
                                            <p class="font-medium text-gray-900">
                                                {{ $participant->personalDetail->full_name ?? '-' }}</p>
                                            <p class="text-xs text-gray-600">{{ $participant->registration_code }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('interviewer.participants.show', $participant->id) }}"
                                        class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        Detail
                                    </a>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-gray-500 text-sm">Semua peserta sudah diinterview</p>
                                </div>
                            @endforelse
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('interviewer.participants.index') }}"
                                class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                Lihat Semua Peserta
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Quick Stats --}}
                <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900">Statistik Interview</h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <p class="text-sm text-gray-600 mb-2">Progress Interview</p>
                                <div class="flex items-center justify-between mb-1">
                                    <span
                                        class="text-2xl font-bold text-gray-900">{{ $completed_interviews ?? 0 }}</span>
                                    <span class="text-sm text-gray-500">dari {{ $total_participants ?? 0 }}</span>
                                </div>
                                @php
                                    $percentage =
                                        ($total_participants ?? 0) > 0
                                            ? (($completed_interviews ?? 0) / ($total_participants ?? 1)) * 100
                                            : 0;
                                @endphp
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-600 h-2 rounded-full" style="width: {{ $percentage }}%">
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col justify-start md:border-l md:border-r border-gray-200 md:px-6">
                                <div class="flex items-baseline gap-2">
                                    <span class="text-2xl font-bold text-gray-900 tracking-tight">
                                        <p class="text-sm text-gray-600 mb-2">Rata-rata Nilai</p>
                                        {{ number_format($average_score ?? 0, 1) }}
                                    </span>
                                    <span class="text-sm text-gray-400 font-medium">/ 100</span>
                                </div>
                            </div>

                            <div>
                                <p class="text-sm text-gray-600 mb-2">Interview Minggu Ini</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $this_week_interviews ?? 0 }}</p>
                                <p class="text-sm text-gray-500">peserta</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
</x-main-layout>
