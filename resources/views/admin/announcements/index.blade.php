<x-main-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Pengumuman') }}</h2>
            <a href="{{ route('admin.announcements.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                + Buat Pengumuman
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="space-y-4">
                        @forelse($announcements ?? [] as $announcement)
                        <div class="border rounded-lg p-4 hover:bg-gray-50 transition">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $announcement->title }}</h3>
                                    <p class="text-gray-600 mt-2 line-clamp-2">{{ $announcement->content }}</p>
                                    <p class="text-sm text-gray-500 mt-2">{{ $announcement->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="flex gap-2 ml-4">
                                    <a href="{{ route('admin.announcements.edit', $announcement->announcements_id) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                                    <form method="POST" action="{{ route('admin.announcements.destroy', $announcement->announcements_id) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Hapus pengumuman?')">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p class="text-center text-gray-500 py-12">Belum ada pengumuman</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>
