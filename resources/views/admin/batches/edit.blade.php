<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Gelombang PMB') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            {{-- Back Button --}}
            <div class="mb-6">
                <a href="{{ route('admin.batches.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Daftar Gelombang
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.batches.update', $batch->id) }}">
                        @csrf
                        @method('PATCH')

                        <div class="space-y-6">
                            {{-- Batch Name --}}
                            <div>
                                <x-input-label for="name" :value="__('Nama Gelombang')" />
                                <x-text-input
                                    id="name"
                                    class="block mt-1 w-full"
                                    type="text"
                                    name="name"
                                    :value="old('name', $batch->name)"
                                    required
                                    autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            {{-- Date Range --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="start_date" :value="__('Tanggal Mulai')" />
                                    <x-text-input
                                        id="start_date"
                                        class="block mt-1 w-full"
                                        type="date"
                                        name="start_date"
                                        :value="old('start_date', $batch->start_date instanceof \Carbon\Carbon ? $batch->start_date->format('Y-m-d') : $batch->start_date)"
                                        required />
                                    <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="end_date" :value="__('Tanggal Berakhir')" />
                                    <x-text-input
                                        id="end_date"
                                        class="block mt-1 w-full"
                                        type="date"
                                        name="end_date"
                                        :value="old('end_date', $batch->end_date instanceof \Carbon\Carbon ? $batch->end_date->format('Y-m-d') : $batch->end_date)"
                                        required />
                                    <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                                </div>
                            </div>

                            {{-- Registration Fee --}}
                            <div>
                                <x-input-label for="registration_fee" :value="__('Biaya Pendaftaran')" />
                                <div class="relative mt-1">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 font-medium">
                                        Rp
                                    </span>
                                    <x-text-input
                                        id="registration_fee"
                                        class="block w-full pl-12"
                                        type="number"
                                        name="registration_fee"
                                        :value="old('registration_fee', $batch->registration_fee)"
                                        min="0"
                                        step="1000" />
                                </div>
                                <x-input-error :messages="$errors->get('registration_fee')" class="mt-2" />
                                <p class="text-sm text-gray-500 mt-1">Biaya yang harus dibayar oleh calon mahasiswa</p>
                            </div>

                            {{-- Description --}}
                            <div>
                                <x-input-label for="description" :value="__('Deskripsi (Opsional)')" />
                                <textarea
                                    id="description"
                                    name="description"
                                    rows="4"
                                    class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">{{ old('description', $batch->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            {{-- Active Status --}}
                            <div class="flex items-start p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center h-5">
                                    <input
                                        id="is_active"
                                        name="is_active"
                                        type="checkbox"
                                        value="1"
                                        {{ old('is_active', $batch->is_active) ? 'checked' : '' }}
                                        class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </div>
                                <div class="ml-3">
                                    <label for="is_active" class="font-medium text-gray-700">Aktifkan gelombang ini</label>
                                    <p class="text-sm text-gray-500 mt-1">
                                        Jika diaktifkan, gelombang lain akan otomatis dinonaktifkan
                                    </p>
                                </div>
                            </div>

                            {{-- Statistics --}}
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <h4 class="font-semibold text-blue-900 mb-3">Statistik Gelombang</h4>
                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <p class="text-xs text-blue-700">Total Pendaftar</p>
                                        <p class="text-2xl font-bold text-blue-900">{{ $batch->registrations()->count() }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-blue-700">Dibuat</p>
                                        <p class="text-sm font-medium text-blue-900">{{ $batch->created_at->format('d M Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-blue-700">Terakhir Diubah</p>
                                        <p class="text-sm font-medium text-blue-900">{{ $batch->updated_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Warning if has registrations --}}
                            @if($batch->registrations()->count() > 0)
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                                <div class="flex">
                                    <svg class="h-5 w-5 text-yellow-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-700">
                                            <strong class="font-semibold">Perhatian:</strong> Gelombang ini sudah memiliki
                                            <strong>{{ $batch->registrations()->count() }} pendaftar</strong>.
                                            Hati-hati saat mengubah tanggal dan biaya pendaftaran.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            {{-- Submit Buttons --}}
                            <div class="flex gap-3 pt-4">
                                <x-primary-button>
                                    {{ __('Simpan Perubahan') }}
                                </x-primary-button>
                                <x-secondary-button type="button" onclick="window.location='{{ route('admin.batches.index') }}'">
                                    {{ __('Batal') }}
                                </x-secondary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Danger Zone --}}
            @if(!$batch->is_active && $batch->registrations()->count() == 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 border-l-4 border-red-500">
                    <h3 class="text-lg font-semibold text-red-600 mb-2">Danger Zone</h3>
                    <p class="text-sm text-gray-600 mb-4">
                        Hapus gelombang ini secara permanen. Tindakan ini tidak dapat dibatalkan.
                    </p>
                    <form method="POST" action="{{ route('admin.batches.destroy', $batch->id) }}"
                          onsubmit="return confirm('Yakin ingin menghapus gelombang ini? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf
                        @method('DELETE')
                        <x-danger-button type="submit">
                            {{ __('Hapus Gelombang') }}
                        </x-danger-button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-main-layout>
