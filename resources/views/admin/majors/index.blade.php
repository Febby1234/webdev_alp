<x-main-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Jurusan') }}</h2>
            <a href="{{ route('admin.majors.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                + Tambah Jurusan
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($majors ?? [] as $major)
                        <div class="border rounded-lg p-6 hover:shadow-lg transition">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $major->majors_name }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">{{ $major->majors_description ?? 'Tidak ada deskripsi' }}</p>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $major->majors_is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $major->majors_is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>

                            <div class="mb-4">
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-600">Kuota</span>
                                    <span class="font-semibold text-gray-900">{{ $major->registered ?? 0 }} / {{ $major->majors_quota }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ (($major->registered ?? 0) / $major->majors_quota) * 100 }}%"></div>
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ route('admin.majors.edit', $major->majors_id) }}" class="flex-1 px-3 py-2 bg-blue-600 text-white text-sm text-center rounded hover:bg-blue-700">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.majors.destroy', $major->majors_id) }}" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full px-3 py-2 bg-red-600 text-white text-sm rounded hover:bg-red-700" onclick="return confirm('Hapus jurusan?')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-3 text-center py-12">
                            <p class="text-gray-500">Belum ada jurusan</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>
