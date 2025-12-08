<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Buat Jadwal Ujian') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.schedules.store') }}">
                        @csrf

                        <div class="space-y-6">
                            <div>
                                <x-input-label for="type" :value="__('Jenis Ujian')" />
                                <select id="type" name="type" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
                                    <option value="">Pilih Jenis Ujian</option>
                                    <option value="Ujian Tertulis">Ujian Tertulis</option>
                                    <option value="Ujian Wawancara">Ujian Wawancara</option>
                                    <option value="Tes Psikologi">Tes Psikologi</option>
                                    <option value="Tes Kesehatan">Tes Kesehatan</option>
                                </select>
                            </div>

                            <div>
                                <x-input-label for="date" :value="__('Tanggal')" />
                                <x-text-input id="date" class="block mt-1 w-full" type="date" name="date" required />
                            </div>

                            <div>
                                <x-input-label for="time" :value="__('Waktu')" />
                                <x-text-input id="time" class="block mt-1 w-full" type="time" name="time" required />
                            </div>

                            <div>
                                <x-input-label for="location" :value="__('Lokasi')" />
                                <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" placeholder="Gedung A Lantai 2" required />
                            </div>

                            <div class="flex gap-3">
                                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                    Simpan Jadwal
                                </button>
                                <a href="{{ route('admin.schedules.index') }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
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
