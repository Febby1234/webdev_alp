<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Peserta Interview') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Filter --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari nama/kode..."
                                class="w-full border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-md shadow-sm">
                        </div>

                        <div>
                            <select name="status" class="w-full border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-md shadow-sm">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Belum Interview</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Sudah Interview</option>
                            </select>
                        </div>

                        <div>
                            <select name="major_id" class="w-full border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-md shadow-sm">
                                <option value="">Semua Jurusan</option>
                                @foreach($majors ?? [] as $major)
                                <option value="{{ $major->majors_id }}" {{ request('major_id') == $major->majors_id ? 'selected' : '' }}>
                                    {{ $major->majors_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition">
                                Filter
                            </button>
                            <a href="{{ route('interviewer.participants.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Table --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-6 text-gray-900">
                        Total: {{ $participants->total() ?? 0 }} Peserta
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jurusan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jadwal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nilai</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($participants ?? [] as $index => $participant)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $participants->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-mono font-semibold text-gray-900">{{ $participant->registration_code }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 font-bold">
                                                {{ substr($participant->personalDetail->fullname ?? 'U', 0, 1) }}
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">{{ $participant->personalDetail->fullname ?? '-' }}</p>
                                                <p class="text-xs text-gray-500">{{ $participant->personalDetail->phone ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $participant->major->majors_name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        @if($participant->schedule)
                                        {{ date('d M Y', strtotime($participant->schedule->date)) }}<br>
                                        <span class="text-xs">{{ date('H:i', strtotime($participant->schedule->time)) }} WIB</span>
                                        @else
                                        <span class="text-gray-400">Belum dijadwalkan</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($participant->examResult)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Selesai
                                        </span>
                                        @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($participant->examResult)
                                        <span class="font-bold text-green-600">{{ $participant->examResult->score }}</span>
                                        @else
                                        <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('interviewer.participants.show', $participant->registration_id) }}"
                                           class="text-purple-600 hover:text-purple-900">
                                            {{ $participant->examResult ? 'Lihat' : 'Interview' }}
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                        Tidak ada data peserta
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if($participants && $participants->hasPages())
                    <div class="mt-6">
                        {{ $participants->links() }}
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
