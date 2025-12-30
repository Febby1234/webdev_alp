<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Jurusan') }}
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
                    <form method="POST" action="{{ route('admin.majors.update', $major->id) }}">
                        @csrf
                        @method('PATCH')

                        <div class="space-y-6">
                            {{-- Major Name --}}
                            <div>
                                <x-input-label for="name" :value="__('Nama Jurusan')" />
                                <x-text-input
                                    id="name"
                                    class="block mt-1 w-full"
                                    type="text"
                                    name="name"
                                    :value="old('name', $major->name)"
                                    required
                                    autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            {{-- Description --}}
                            <div>
                                <x-input-label for="description" :value="__('Deskripsi')" />
                                <textarea
                                    id="description"
                                    name="description"
                                    rows="4"
                                    class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">{{ old('description', $major->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            {{-- Quota --}}
                            <div>
                                <x-input-label for="quota" :value="__('Kuota Mahasiswa')" />
                                <x-text-input
                                    id="quota"
                                    class="block mt-1 w-full"
                                    type="number"
                                    name="quota"
                                    :value="old('quota', $major->quota)"
                                    required
                                    min="{{ $major->registrations()->count() }}"
                                    max="1000" />
                                <x-input-error :messages="$errors->get('quota')" class="mt-2" />
                                @if($major->registrations()->count() > 0)
                                <p class="text-sm text-yellow-600 mt-1">
                                    ⚠️ Minimal kuota: {{ $major->registrations()->count() }} (sesuai jumlah pendaftar saat ini)
                                </p>
                                @endif
                            </div>

                            {{-- Active Status --}}
                            <div class="flex items-start p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center h-5">
                                    <input
                                        id="is_active"
                                        type="checkbox"
                                        name="is_active"
                                        value="1"
                                        {{ old('is_active', $major->is_active) ? 'checked' : '' }}
                                        class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </div>
                                <div class="ml-3">
                                    <label for="is_active" class="font-medium text-gray-700">Aktifkan jurusan ini</label>
                                    <p class="text-sm text-gray-500 mt-1">
                                        Jurusan yang nonaktif tidak akan muncul di halaman pendaftaran
                                    </p>
                                </div>
                            </div>

                            {{-- Statistics --}}
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <h4 class="font-semibold text-blue-900 mb-3">Statistik Jurusan</h4>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs text-blue-700">Total Pendaftar</p>
                                        <p class="text-2xl font-bold text-blue-900">{{ $major->registrations()->count() }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-blue-700">Sisa Kuota</p>
                                        <p class="text-2xl font-bold text-blue-900">{{ max(0, $major->quota - $major->registrations()->count()) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-blue-700">Dibuat</p>
                                        <p class="text-sm font-medium text-blue-900">{{ $major->created_at->format('d M Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-blue-700">Terakhir Diubah</p>
                                        <p class="text-sm font-medium text-blue-900">{{ $major->updated_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Submit Buttons --}}
                            <div class="flex gap-3 pt-4">
                                <x-primary-button>
                                    {{ __('Simpan Perubahan') }}
                                </x-primary-button>
                                <x-secondary-button type="button" onclick="window.location='{{ route('admin.majors.index') }}'">
                                    {{ __('Batal') }}
                                </x-secondary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Danger Zone --}}
            @if($major->registrations()->count() == 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 border-l-4 border-red-500">
                    <h3 class="text-lg font-semibold text-red-600 mb-2">Danger Zone</h3>
                    <p class="text-sm text-gray-600 mb-4">
                        Hapus jurusan ini secara permanen. Tindakan ini tidak dapat dibatalkan.
                    </p>
                    <form method="POST" action="{{ route('admin.majors.destroy', $major->id) }}"
                          onsubmit="return confirm('Yakin ingin menghapus jurusan {{ $major->name }}? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf
                        @method('DELETE')
                        <x-danger-button type="submit">
                            {{ __('Hapus Jurusan') }}
                        </x-danger-button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-main-layout>
