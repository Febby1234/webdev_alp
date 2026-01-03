<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Jadwal Ujian Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            {{-- Back Button --}}
            <div class="mb-6">
                <a href="{{ route('admin.schedules.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Daftar Jadwal
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.schedules.store') }}">
                        @csrf

                        <div class="space-y-6">
                            {{-- Batch --}}
                            <div>
                                <x-input-label for="batch_id" :value="__('Gelombang')" />
                                <select id="batch_id"
                                        name="batch_id"
                                        class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                                    <option value="">Pilih Gelombang (Opsional)</option>
                                    @foreach($batches as $batch)
                                    <option value="{{ $batch->id }}" {{ old('batch_id', $schedule->batch_id ?? '') == $batch->id ? 'selected' : '' }}>
                                        {{ $batch->batch_name }}
                                    </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('batch_id')" class="mt-2" />
                                <p class="text-sm text-gray-500 mt-1">Jadwal akan berlaku untuk gelombang yang dipilih</p>
                            </div>
                            
                            {{-- Exam Type --}}
                            <div>
                                <x-input-label for="type" :value="__('Jenis Ujian')" />
                                <select id="type"
                                        name="type"
                                        class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                                        required>
                                    <option value="">Pilih Jenis Ujian</option>
                                    <option value="Ujian Tertulis" {{ old('type') == 'Ujian Tertulis' ? 'selected' : '' }}>Ujian Tertulis</option>
                                    <option value="Ujian Wawancara" {{ old('type') == 'Ujian Wawancara' ? 'selected' : '' }}>Ujian Wawancara</option>
                                    <option value="Tes Psikologi" {{ old('type') == 'Tes Psikologi' ? 'selected' : '' }}>Tes Psikologi</option>
                                    <option value="Tes Kesehatan" {{ old('type') == 'Tes Kesehatan' ? 'selected' : '' }}>Tes Kesehatan</option>
                                </select>
                                <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            </div>

                            {{-- Date --}}
                            <div>
                                <x-input-label for="date" :value="__('Tanggal Pelaksanaan')" />
                                <x-text-input id="date"
                                              class="block mt-1 w-full"
                                              type="date"
                                              name="date"
                                              :value="old('date')"
                                              required
                                              min="{{ now()->format('Y-m-d') }}" />
                                <x-input-error :messages="$errors->get('date')" class="mt-2" />
                                <p class="text-sm text-gray-500 mt-1">Pilih tanggal pelaksanaan ujian</p>
                            </div>

                            {{-- Time --}}
                            <div>
                                <x-input-label for="time" :value="__('Waktu Mulai')" />
                                <x-text-input id="time"
                                              class="block mt-1 w-full"
                                              type="time"
                                              name="time"
                                              :value="old('time')"
                                              required />
                                <x-input-error :messages="$errors->get('time')" class="mt-2" />
                                <p class="text-sm text-gray-500 mt-1">Format 24 jam (contoh: 14:00)</p>
                            </div>

                            {{-- Location --}}
                            <div>
                                <x-input-label for="location" :value="__('Lokasi Pelaksanaan')" />
                                <x-text-input id="location"
                                              class="block mt-1 w-full"
                                              type="text"
                                              name="location"
                                              :value="old('location')"
                                              placeholder="Contoh: Gedung A Lantai 2, Ruang 201"
                                              required />
                                <x-input-error :messages="$errors->get('location')" class="mt-2" />
                            </div>

                            {{-- Info Box --}}
                            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                                <div class="flex">
                                    <svg class="h-5 w-5 text-blue-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div class="ml-3">
                                        <p class="text-sm text-blue-700 font-medium">Tips Membuat Jadwal:</p>
                                        <ul class="text-sm text-blue-700 mt-2 space-y-1 list-disc list-inside">
                                            <li>Pastikan tanggal dan waktu tidak bentrok dengan jadwal lain</li>
                                            <li>Pilih lokasi yang mudah diakses oleh peserta</li>
                                            <li>Beri jeda waktu yang cukup antar sesi ujian</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            {{-- Submit Buttons --}}
                            <div class="flex gap-3 pt-4">
                                <x-primary-button>
                                    {{ __('Simpan Jadwal') }}
                                </x-primary-button>
                                <x-secondary-button type="button" onclick="window.location='{{ route('admin.schedules.index') }}'">
                                    {{ __('Batal') }}
                                </x-secondary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>
