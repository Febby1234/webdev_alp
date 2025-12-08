<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Gelombang PMB Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.batches.store') }}">
                        @csrf

                        <div class="space-y-6">
                            {{-- Batch Name --}}
                            <div>
                                <x-input-label for="batch_name" :value="__('Nama Gelombang')" class="required" />
                                <x-text-input id="batch_name" class="block mt-1 w-full" type="text" name="batch_name"
                                    :value="old('batch_name')"
                                    placeholder="Contoh: Gelombang 1 - 2025"
                                    required />
                                <x-input-error :messages="$errors->get('batch_name')" class="mt-2" />
                                <p class="text-sm text-gray-500 mt-1">Nama yang mudah dikenali, contoh: Gelombang 1, Gelombang 2, dst.</p>
                            </div>

                            {{-- Date Range --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="start_date" :value="__('Tanggal Mulai')" class="required" />
                                    <x-text-input id="start_date" class="block mt-1 w-full" type="date" name="start_date"
                                        :value="old('start_date')"
                                        required />
                                    <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="end_date" :value="__('Tanggal Berakhir')" class="required" />
                                    <x-text-input id="end_date" class="block mt-1 w-full" type="date" name="end_date"
                                        :value="old('end_date')"
                                        required />
                                    <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                                </div>
                            </div>

                            {{-- Registration Fee --}}
                            <div>
                                <x-input-label for="registration_fee" :value="__('Biaya Pendaftaran')" />
                                <div class="relative mt-1">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                        Rp
                                    </span>
                                    <x-text-input id="registration_fee" class="block w-full pl-12" type="number" name="registration_fee"
                                        :value="old('registration_fee', 300000)"
                                        min="0"
                                        step="1000" />
                                </div>
                                <x-input-error :messages="$errors->get('registration_fee')" class="mt-2" />
                                <p class="text-sm text-gray-500 mt-1">Biaya yang harus dibayar oleh pendaftar</p>
                            </div>

                            {{-- Description --}}
                            <div>
                                <x-input-label for="description" :value="__('Deskripsi (Opsional)')" />
                                <textarea id="description" name="description" rows="4"
                                    class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                                    placeholder="Keterangan tambahan tentang gelombang ini...">{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            {{-- Active Status --}}
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="is_active" name="is_active" type="checkbox" value="1"
                                        {{ old('is_active', true) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                </div>
                                <div class="ml-3">
                                    <label for="is_active" class="font-medium text-gray-700">Aktifkan gelombang ini</label>
                                    <p class="text-sm text-gray-500">Gelombang yang aktif akan ditampilkan di halaman pendaftaran. Hanya 1 gelombang yang bisa aktif dalam 1 waktu.</p>
                                </div>
                            </div>

                            {{-- Info Box --}}
                            <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                                <div class="flex">
                                    <svg class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div class="ml-3">
                                        <p class="text-sm text-blue-700">
                                            <strong>Tips:</strong>
                                        </p>
                                        <ul class="text-sm text-blue-700 mt-2 list-disc list-inside">
                                            <li>Pastikan tanggal mulai dan berakhir sesuai dengan kalender akademik</li>
                                            <li>Jika mengaktifkan gelombang ini, gelombang lain akan otomatis dinonaktifkan</li>
                                            <li>Anda masih bisa mengubah detail gelombang setelah dibuat</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            {{-- Submit Buttons --}}
                            <div class="flex gap-3 pt-4">
                                <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                                    Buat Gelombang
                                </button>
                                <a href="{{ route('admin.batches.index') }}" class="px-6 py-2 bg-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-400 transition">
                                    Batal
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>
