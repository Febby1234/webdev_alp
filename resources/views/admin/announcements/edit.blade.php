<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pengumuman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            {{-- Back Button --}}
            <div class="mb-6">
                <a href="{{ route('admin.announcements.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Daftar Pengumuman
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.announcements.update', $announcement->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="space-y-6">
                            {{-- Title --}}
                            <div>
                                <x-input-label for="title" :value="__('Judul Pengumuman')" />
                                <x-text-input
                                    id="title"
                                    class="block mt-1 w-full"
                                    type="text"
                                    name="title"
                                    :value="old('title', $announcement->title)"
                                    required
                                    autofocus />
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
                                    required>{{ old('content', $announcement->content) }}</textarea>
                                <x-input-error :messages="$errors->get('content')" class="mt-2" />
                                <p class="text-sm text-gray-500 mt-1">Minimal 10 karakter</p>
                            </div>

                            {{-- Current Banner --}}
                            @if($announcement->banner_image)
                            <div>
                                <x-input-label :value="__('Banner Saat Ini')" />
                                <div class="mt-2 relative">
                                    <img src="{{ Storage::url($announcement->banner_image) }}"
                                         alt="Current Banner"
                                         class="w-full h-48 object-cover rounded-lg">
                                    <div class="absolute top-2 right-2">
                                        <label class="inline-flex items-center px-3 py-1 bg-red-600 text-white text-xs rounded-lg cursor-pointer hover:bg-red-700">
                                            <input type="checkbox" name="remove_banner" value="1" class="mr-2">
                                            Hapus Banner
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @endif

                            {{-- New Banner Image --}}
                            <div>
                                <x-input-label for="banner_image" :value="__('Ganti Banner (Opsional)')" />
                                <input
                                    id="banner_image"
                                    type="file"
                                    name="banner_image"
                                    accept="image/jpeg,image/jpg,image/png"
                                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 mt-1
                                           file:mr-4 file:py-2 file:px-4 file:rounded-l-lg file:border-0 file:text-sm file:font-semibold
                                           file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <x-input-error :messages="$errors->get('banner_image')" class="mt-2" />
                                <p class="text-sm text-gray-500 mt-1">
                                    @if($announcement->banner_image)
                                        Upload gambar baru untuk mengganti banner yang ada
                                    @else
                                        Format: JPG, PNG • Maksimal 2MB • Resolusi optimal: 1200x400px
                                    @endif
                                </p>
                            </div>

                            {{-- Metadata Info --}}
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <span class="text-gray-600">Dibuat:</span>
                                        <span class="text-gray-900 font-medium ml-2">
                                            {{ $announcement->created_at->format('d M Y, H:i') }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Terakhir Diubah:</span>
                                        <span class="text-gray-900 font-medium ml-2">
                                            {{ $announcement->updated_at->format('d M Y, H:i') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- Submit Buttons --}}
                            <div class="flex gap-3 pt-4">
                                <x-primary-button>
                                    {{ __('Simpan Perubahan') }}
                                </x-primary-button>
                                <x-secondary-button type="button" onclick="window.location='{{ route('admin.announcements.index') }}'">
                                    {{ __('Batal') }}
                                </x-secondary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Danger Zone --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 border-l-4 border-red-500">
                    <h3 class="text-lg font-semibold text-red-600 mb-2">Danger Zone</h3>
                    <p class="text-sm text-gray-600 mb-4">Hapus pengumuman ini secara permanen. Tindakan ini tidak dapat dibatalkan.</p>
                    <form method="POST" action="{{ route('admin.announcements.destroy', $announcement->id) }}"
                          onsubmit="return confirm('Yakin ingin menghapus pengumuman ini? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf
                        @method('DELETE')
                        <x-danger-button type="submit">
                            {{ __('Hapus Pengumuman') }}
                        </x-danger-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>
