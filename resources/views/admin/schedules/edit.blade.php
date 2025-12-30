<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Jadwal Ujian') }}
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
                    <form method="POST" action="{{ route('admin.schedules.update', $schedule->id) }}">
                        @csrf
                        @method('PATCH')

                        <div class="space-y-6">
                            {{-- Exam Type --}}
                            <div>
                                <x-input-label for="type" :value="__('Jenis Ujian')" />
                                <select id="type"
                                        name="type"
                                        class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                                        required>
                                    <option value="">Pilih Jenis Ujian</option>
                                    <option value="Ujian Tertulis" {{ old('type', $schedule->type) == 'Ujian Tertulis' ? 'selected' : '' }}>Ujian Tertulis</option>
                                    <option value="Ujian Wawancara" {{ old('type', $schedule->type) == 'Ujian Wawancara' ? 'selected' : '' }}>Ujian Wawancara</option>
                                    <option value="Tes Psikologi" {{ old('type', $schedule->type) == 'Tes Psikologi' ? 'selected' : '' }}>Tes Psikologi</option>
                                    <option value="Tes Kesehatan" {{ old('type', $schedule->type) == 'Tes Kesehatan' ? 'selected' : '' }}>Tes Kesehatan</option>
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
                                              :value="old('date', $schedule->date instanceof \Carbon\Carbon ? $schedule->date->format('Y-m-d') : $schedule->date)"
                                              required
                                              min="{{ now()->format('Y-m-d') }}" />
                                <x-input-error :messages="$errors->get('date')" class="mt-2" />
                            </div>

                            {{-- Time --}}
                            <div>
                                <x-input-label for="time" :value="__('Waktu Mulai')" />
                                <x-text-input id="time"
                                              class="block mt-1 w-full"
                                              type="time"
                                              name="time"
                                              :value="old('time', $schedule->time instanceof \Carbon\Carbon ? $schedule->time->format('H:i') : $schedule->time)"
                                              required />
                                <x-input-error :messages="$errors->get('time')" class="mt-2" />
                            </div>

                            {{-- Location --}}
                            <div>
                                <x-input-label for="location" :value="__('Lokasi Pelaksanaan')" />
                                <x-text-input id="location"
                                              class="block mt-1 w-full"
                                              type="text"
                                              name="location"
                                              :value="old('location', $schedule->location)"
                                              required />
                                <x-input-error :messages="$errors->get('location')" class="mt-2" />
                            </div>

                            {{-- Capacity (Optional) --}}
                            <div>
                                <x-input-label for="capacity" :value="__('Kapasitas (Opsional)')" />
                                <x-text-input id="capacity"
                                              class="block mt-1 w-full"
                                              type="number"
                                              name="capacity"
                                              :value="old('capacity', $schedule->capacity)"
                                              min="{{ $schedule->registrations()->count() }}" />
                                <x-input-error :messages="$errors->get('capacity')" class="mt-2" />
                                @if($schedule->registrations()->count() > 0)
                                <p class="text-sm text-yellow-600 mt-1">
                                    ⚠️ Minimal kapasitas: {{ $schedule->registrations()->count() }} (sesuai jumlah peserta terdaftar)
                                </p>
                                @endif
                            </div>

                            {{-- Notes (Optional) --}}
                            <div>
                                <x-input-label for="notes" :value="__('Catatan (Opsional)')" />
                                <textarea id="notes"
                                          name="notes"
                                          rows="3"
                                          class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">{{ old('notes', $schedule->notes) }}</textarea>
                                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                            </div>

                            {{-- Statistics --}}
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <h4 class="font-semibold text-blue-900 mb-3">Statistik Jadwal</h4>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs text-blue-700">Total Peserta Terdaftar</p>
                                        <p class="text-2xl font-bold text-blue-900">{{ $schedule->registrations()->count() }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-blue-700">Kapasitas</p>
                                        <p class="text-2xl font-bold text-blue-900">
                                            {{ $schedule->capacity ?? 'Unlimited' }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-blue-700">Dibuat</p>
                                        <p class="text-sm font-medium text-blue-900">{{ $schedule->created_at->format('d M Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-blue-700">Terakhir Diubah</p>
                                        <p class="text-sm font-medium text-blue-900">{{ $schedule->updated_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Submit Buttons --}}
                            <div class="flex gap-3 pt-4">
                                <x-primary-button>
                                    {{ __('Simpan Perubahan') }}
                                </x-primary-button>
                                <x-secondary-button type="button" onclick="window.location='{{ route('admin.schedules.index') }}'">
                                    {{ __('Batal') }}
                                </x-secondary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Danger Zone --}}
            @if($schedule->registrations()->count() == 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 border-l-4 border-red-500">
                    <h3 class="text-lg font-semibold text-red-600 mb-2">Danger Zone</h3>
                    <p class="text-sm text-gray-600 mb-4">
                        Hapus jadwal ini secara permanen. Tindakan ini tidak dapat dibatalkan.
                    </p>
                    <form method="POST" action="{{ route('admin.schedules.destroy', $schedule->id) }}"
                          onsubmit="return confirm('Yakin ingin menghapus jadwal {{ $schedule->type }}? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf
                        @method('DELETE')
                        <x-danger-button type="submit">
                            {{ __('Hapus Jadwal') }}
                        </x-danger-button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-main-layout>
