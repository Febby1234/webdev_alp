<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jadwal Interview') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Filter by Date --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" class="flex gap-4 items-end">
                        <div class="flex-1">
                            <x-input-label for="date" :value="__('Pilih Tanggal')" />
                            <x-text-input id="date" class="block mt-1 w-full" type="date" name="date" :value="request('date', date('Y-m-d'))" />
                        </div>
                        <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition">
                            Filter
                        </button>
                        <a href="{{ route('interviewer.schedule.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition">
                            Reset
                        </a>
                    </form>
                </div>
            </div>

            {{-- Calendar View --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Jadwal: {{ request('date') ? date('d F Y', strtotime(request('date'))) : 'Hari Ini' }}
                        </h3>
                        <div class="flex gap-2">
                            <a href="{{ route('interviewer.schedule.index', ['date' => date('Y-m-d', strtotime('-1 day', strtotime(request('date', date('Y-m-d')))))]) }}"
                               class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                                ← Prev
                            </a>
                            <a href="{{ route('interviewer.schedule.index', ['date' => date('Y-m-d')]) }}"
                               class="px-3 py-1 bg-purple-600 text-white rounded hover:bg-purple-700">
                                Today
                            </a>
                            <a href="{{ route('interviewer.schedule.index', ['date' => date('Y-m-d', strtotime('+1 day', strtotime(request('date', date('Y-m-d')))))]) }}"
                               class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                                Next →
                            </a>
                        </div>
                    </div>

                    {{-- Timeline Schedule --}}
                    <div class="space-y-4">
                        @forelse($schedules ?? [] as $time => $interviews)
                        <div class="border-l-4 border-purple-600 pl-6 py-3 bg-purple-50 rounded-r-lg">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-20">
                                    <p class="text-lg font-bold text-purple-900">{{ $time }}</p>
                                    <p class="text-xs text-purple-600">WIB</p>
                                </div>
                                <div class="flex-1 ml-6">
                                    @foreach($interviews as $interview)
                                    <div class="bg-white rounded-lg p-4 mb-3 last:mb-0 shadow-sm hover:shadow-md transition">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center flex-1">
                                                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 font-bold text-lg">
                                                    {{ substr($interview->participant->personalDetail->fullname ?? 'U', 0, 1) }}
                                                </div>
                                                <div class="ml-4">
                                                    <h4 class="font-semibold text-gray-900">{{ $interview->participant->personalDetail->fullname ?? '-' }}</h4>
                                                    <div class="flex items-center gap-3 mt-1">
                                                        <p class="text-sm text-gray-600">{{ $interview->participant->registration_code }}</p>
                                                        <span class="text-sm text-gray-400">•</span>
                                                        <p class="text-sm text-gray-600">{{ $interview->participant->major->majors_name ?? '-' }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-3">
                                                @if($interview->examResult)
                                                <div class="text-right mr-4">
                                                    <p class="text-sm text-gray-600">Nilai</p>
                                                    <p class="text-2xl font-bold text-green-600">{{ $interview->examResult->score }}</p>
                                                </div>
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    ✓ Selesai
                                                </span>
                                                @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    Pending
                                                </span>
                                                @endif

                                                <a href="{{ route('interviewer.participants.show', $interview->participant->registration_id) }}"
                                                   class="px-4 py-2 bg-purple-600 text-white text-sm rounded-lg hover:bg-purple-700 transition">
                                                    {{ $interview->examResult ? 'Lihat' : 'Interview' }} →
                                                </a>
                                            </div>
                                        </div>

                                        {{-- Location Info --}}
                                        <div class="mt-3 pt-3 border-t border-gray-100 flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            {{ $interview->schedule->location ?? '-' }}
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-gray-500">Tidak ada jadwal interview untuk tanggal ini</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Upcoming Schedule --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-6 text-gray-900">Jadwal Mendatang (7 Hari ke Depan)</h3>

                    <div class="space-y-3">
                        @forelse($upcoming_schedules ?? [] as $schedule)
                        <div class="border rounded-lg p-4 hover:bg-gray-50 transition">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-16 h-16 bg-purple-100 rounded-lg flex items-center justify-center flex-col">
                                        <p class="text-2xl font-bold text-purple-600">{{ date('d', strtotime($schedule->date)) }}</p>
                                        <p class="text-xs text-purple-600">{{ date('M', strtotime($schedule->date)) }}</p>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="font-semibold text-gray-900">{{ $schedule->type }}</h4>
                                        <p class="text-sm text-gray-600">{{ date('l, d F Y', strtotime($schedule->date)) }}</p>
                                        <p class="text-sm text-gray-600">{{ date('H:i', strtotime($schedule->time)) }} WIB - {{ $schedule->location }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-600">Peserta</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $schedule->participants_count ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p class="text-center text-gray-500 py-8">Tidak ada jadwal mendatang</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
