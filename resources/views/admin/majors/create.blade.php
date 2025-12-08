<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Tambah Jurusan') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.majors.store') }}">
                        @csrf

                        <div class="space-y-6">
                            <div>
                                <x-input-label for="majors_name" :value="__('Nama Jurusan')" />
                                <x-text-input id="majors_name" class="block mt-1 w-full" type="text" name="majors_name" :value="old('majors_name')" required />
                            </div>

                            <div>
                                <x-input-label for="majors_description" :value="__('Deskripsi')" />
                                <textarea id="majors_description" name="majors_description" rows="4"
                                    class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">{{ old('majors_description') }}</textarea>
                            </div>

                            <div>
                                <x-input-label for="majors_quota" :value="__('Kuota')" />
                                <x-text-input id="majors_quota" class="block mt-1 w-full" type="number" name="majors_quota" :value="old('majors_quota')" required min="1" />
                            </div>

                            <div class="flex items-center">
                                <input id="majors_is_active" type="checkbox" name="majors_is_active" value="1" checked
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <label for="majors_is_active" class="ml-2 text-sm text-gray-700">Aktifkan jurusan ini</label>
                            </div>

                            <div class="flex gap-3">
                                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                    Simpan Jurusan
                                </button>
                                <a href="{{ route('admin.majors.index') }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
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
