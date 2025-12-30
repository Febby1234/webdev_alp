<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Pengumuman Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.announcements.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="space-y-6">
                            {{-- Title --}}
                            <div>
                                <x-input-label for="title" :value="__('Judul Pengumuman')" />
                                <x-text-input
                                    id="title"
                                    class="block mt-1 w-full"
                                    type="text"
                                    name="title"
                                    :value="old('title')"
                                    required
                                    autofocus
                                    placeholder="Contoh: Pengumuman Hasil Seleksi Gelombang 1" />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            {{-- Content --}}
                            <div>
                                <x-input-label for="content" :value="__('Isi Pengumuman')" />
                                <textarea
                                    id="content"
                                    name="content"
                                    rows="10"
                                    class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                                    required
                                    placeholder="Tulis isi pengumuman di sini...">{{ old('content') }}</textarea>
                                <x-input-error :messages="$errors->get('content')" class="mt-2" />
                                <p class="text-sm text-gray-500 mt-1">Minimal 10 karakter</p>
                            </div>

                            {{-- Banner Image --}}
                            <div>
                                <x-input-label for="banner_image" :value="__('Gambar Banner (Opsional)')" />
                                <input
                                    id="banner_image"
                                    type="file"
                                    name="banner_image"
                                    accept="image/jpeg,image/jpg,image/png"
                                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 mt-1
                                           file:mr-4 file:py-2 file:px-4 file:rounded-l-lg file:border-0 file:text-sm file:font-semibold
                                           file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <x-input-error :messages="$errors->get('banner_image')" class="mt-2" />
                                <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG • Maksimal 2MB • Resolusi optimal: 1200x400px</p>
                            </div>

                            {{-- Info Box --}}
                            <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                                <div class="flex">
                                    <svg class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div class="ml-3">
                                        <p class="text-sm text-blue-700">
                                            <strong>Tips:</strong> Pengumuman akan langsung ditampilkan di halaman publik setelah dipublish.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Submit Buttons --}}
                            <div class="flex gap-3 pt-4">
                                <x-primary-button>
                                    {{ __('Publish Pengumuman') }}
                                </x-primary-button>
                                <x-secondary-button type="button" onclick="window.location='{{ route('admin.announcements.index') }}'">
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
