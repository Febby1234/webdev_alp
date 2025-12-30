<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Jurusan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            {{-- Back Button --}}
            <div class="mb-6">
                <a href="{{ route('admin.majors.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Daftar Jurusan
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.majors.store') }}">
                        @csrf

                        <div class="space-y-6">
                            {{-- Major Name --}}
                            <div>
                                <x-input-label for="name" :value="__('Nama Jurusan')" />
                                <x-text-input
                                    id="name"
                                    class="block mt-1 w-full"
                                    type="text"
                                    name="name"
                                    :value="old('name')"
                                    required
                                    autofocus
                                    placeholder="Contoh: Teknik Informatika" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            {{-- Description --}}
                            <div>
                                <x-input-label for="description" :value="__('Deskripsi')" />
                                <textarea
                                    id="description"
                                    name="description"
                                    rows="4"
                                    class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                                    placeholder="Deskripsi singkat tentang jurusan ini...">{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                <p class="text-sm text-gray-500 mt-1">Opsional - Deskripsi akan ditampilkan di halaman publik</p>
                            </div>

                            {{-- Quota --}}
                            <div>
                                <x-input-label for="quota" :value="__('Kuota Mahasiswa')" />
                                <x-text-input
                                    id="quota"
                                    class="block mt-1 w-full"
                                    type="number"
                                    name="quota"
                                    :value="old('quota', 30)"
                                    required
                                    min="1"
                                    max="1000" />
                                <x-input-error :messages="$errors->get('quota')" class="mt-2" />
                                <p class="text-sm text-gray-500 mt-1">Jumlah maksimal mahasiswa yang dapat diterima di jurusan ini</p>
                            </div>

                            {{-- Active Status --}}
                            <div class="flex items-start p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center h-5">
                                    <input
                                        id="is_active"
                                        type="checkbox"
                                        name="is_active"
                                        value="1"
                                        {{ old('is_active', true) ? 'checked' : '' }}
                                        class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </div>
                                <div class="ml-3">
                                    <label for="is_active" class="font-medium text-gray-700">Aktifkan jurusan ini</label>
                                    <p class="text-sm text-gray-500 mt-1">
                                        Jurusan yang aktif akan ditampilkan di halaman pendaftaran dan dapat menerima pendaftar baru
                                    </p>
                                </div>
                            </div>

                            {{-- Info Box --}}
                            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                                <div class="flex">
                                    <svg class="h-5 w-5 text-blue-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div class="ml-3">
                                        <p class="text-sm text-blue-700 font-medium">Tips Menambah Jurusan:</p>
                                        <ul class="text-sm text-blue-700 mt-2 space-y-1 list-disc list-inside">
                                            <li>Pastikan nama jurusan jelas dan mudah dipahami calon mahasiswa</li>
                                            <li>Deskripsi yang baik membantu calon mahasiswa memilih jurusan yang tepat</li>
                                            <li>Kuota dapat diubah sewaktu-waktu sesuai kebutuhan</li>
                                            <li>Jurusan tidak dapat dihapus jika sudah ada pendaftar</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            {{-- Submit Buttons --}}
                            <div class="flex gap-3 pt-4">
                                <x-primary-button>
                                    {{ __('Simpan Jurusan') }}
                                </x-primary-button>
                                <x-secondary-button type="button" onclick="window.location='{{ route('admin.majors.index') }}'">
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
