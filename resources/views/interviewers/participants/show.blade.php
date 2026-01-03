<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Peserta & Input Nilai') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- Back Button --}}
            <div class="mb-6">
                <a href="{{ route('interviewer.participants.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Daftar Peserta
                </a>
            </div>

            {{-- Success/Error Message --}}
            @if(session('success'))
                <div class="mb-6">
                    <x-alert type="success">{{ session('success') }}</x-alert>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6">
                    <x-alert type="error">{{ session('error') }}</x-alert>
                </div>
            @endif

            {{-- Participant Header --}}
            <div class="bg-gradient-to-r from-purple-600 to-purple-700 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center text-3xl font-bold text-purple-600">
                                {{ substr($participant->personalDetail->full_name ?? 'U', 0, 1) }}
                            </div>
                            <div class="ml-6">
                                <h3 class="text-2xl font-bold">{{ $participant->personalDetail->full_name ?? '-' }}</h3>
                                <p class="text-purple-100 mt-1">{{ $participant->registration_code }}</p>
                                <p class="text-purple-100 text-sm">{{ $participant->major->name ?? '-' }}</p>
                            </div>
                        </div>
                        @if($examResult)
                        <div class="text-right">
                            <p class="text-sm opacity-90">Nilai Interview</p>
                            <p class="text-5xl font-bold">{{ $examResult->score }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Biodata --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900">Biodata Pribadi</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Nama Lengkap</label>
                                    <p class="text-gray-900 mt-1">{{ $participant->personalDetail->full_name ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Jenis Kelamin</label>
                                    <p class="text-gray-900 mt-1">{{ $participant->personalDetail->gender ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Tempat, Tanggal Lahir</label>
                                    <p class="text-gray-900 mt-1">
                                        {{ $participant->personalDetail->birth_place ?? '-' }},
                                        {{ $participant->personalDetail->birth_date ? $participant->personalDetail->birth_date->format('d F Y') : '-' }}
                                    </p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">No. Telepon</label>
                                    <p class="text-gray-900 mt-1">{{ $participant->personalDetail->phone ?? '-' }}</p>
                                </div>
                                <div class="col-span-2">
                                    <label class="text-sm font-medium text-gray-600">Alamat</label>
                                    <p class="text-gray-900 mt-1">{{ $participant->personalDetail->address ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900">Pendidikan</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Asal Sekolah</label>
                                    <p class="text-gray-900 mt-1">{{ $participant->schoolOrigin->school_origin_name ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Tahun Lulus</label>
                                    <p class="text-gray-900 mt-1">{{ $participant->schoolOrigin->graduation_year ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Rata-rata Nilai</label>
                                    <p class="text-gray-900 mt-1">{{ $participant->schoolOrigin->average_grade ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Jurusan Dipilih</label>
                                    <p class="text-gray-900 mt-1 font-semibold">{{ $participant->major->name ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Input Nilai Form --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-6 text-gray-900">
                                {{ $examResult ? 'Edit Nilai Interview' : 'Input Nilai Interview' }}
                            </h3>

                            <form method="POST" action="{{ route('interviewer.participants.score', $participant->id) }}">
                                @csrf

                                <div class="space-y-6">
                                    {{-- Score --}}
                                    <div>
                                        <x-input-label for="score" :value="__('Nilai (0-100)')" />
                                        <x-text-input id="score" class="block mt-1 w-full text-2xl font-bold"
                                            type="number" name="score"
                                            :value="old('score', $examResult->score ?? '')"
                                            min="0" max="100" required
                                            placeholder="Masukkan nilai" />
                                        <x-input-error :messages="$errors->get('score')" class="mt-2" />
                                    </div>

                                    {{-- Notes --}}
                                    <div>
                                        <x-input-label for="notes" :value="__('Catatan Interview')" />
                                        <textarea id="notes" name="notes" rows="6"
                                            class="block mt-1 w-full border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-md shadow-sm"
                                            placeholder="Catatan hasil interview, kesan, saran, dll...">{{ old('notes', $examResult->notes ?? '') }}</textarea>
                                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                                    </div>

                                    {{-- Status --}}
                                    <div>
                                        <x-input-label for="status" :value="__('Status')" />
                                        <select id="status" name="status" class="block mt-1 w-full border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-md shadow-sm">
                                            <option value="pass" {{ old('status', $examResult->status ?? '') == 'pass' ? 'selected' : '' }}>
                                                Lulus
                                            </option>
                                            <option value="fail" {{ old('status', $examResult->status ?? '') == 'fail' ? 'selected' : '' }}>
                                                Tidak Lulus
                                            </option>
                                        </select>
                                    </div>

                                    {{-- Submit Button --}}
                                    <div class="flex gap-3">
                                        <button type="submit" class="px-6 py-3 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition">
                                            {{ $examResult ? '✓ Update Nilai' : '✓ Simpan Nilai' }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="space-y-6">
                    {{-- Jadwal Info --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900">Info Jadwal</h3>
                            @if($schedule)
                            <div class="space-y-3 text-sm">
                                <div>
                                    <label class="text-gray-600">Jenis</label>
                                    <p class="text-gray-900 font-medium">{{ $schedule->type }}</p>
                                </div>
                                <div>
                                    <label class="text-gray-600">Tanggal</label>
                                    <p class="text-gray-900">{{ $schedule->date->format('d F Y') }}</p>
                                </div>
                                <div>
                                    <label class="text-gray-600">Waktu</label>
                                    <p class="text-gray-900">{{ $schedule->time }} WIB</p>
                                </div>
                                <div>
                                    <label class="text-gray-600">Lokasi</label>
                                    <p class="text-gray-900">{{ $schedule->location }}</p>
                                </div>
                            </div>
                            @else
                            <p class="text-gray-500 text-sm">Belum ada jadwal interview</p>
                            @endif
                        </div>
                    </div>

                    {{-- Contact Info --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900">Kontak</h3>
                            <div class="space-y-3 text-sm">
                                <div>
                                    <label class="text-gray-600">Email</label>
                                    <p class="text-gray-900">{{ $participant->user->email ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="text-gray-600">Telepon</label>
                                    <p class="text-gray-900">{{ $participant->personalDetail->phone ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Quick Notes --}}
                    <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                        <h4 class="font-semibold text-purple-900 mb-2 text-sm">Tips Penilaian:</h4>
                        <ul class="text-xs text-purple-800 space-y-1 list-disc list-inside">
                            <li>Nilai 0-100</li>
                            <li>Perhatikan sikap & komunikasi</li>
                            <li>Catat poin penting di catatan</li>
                            <li>Objektif & adil</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-main-layout>
