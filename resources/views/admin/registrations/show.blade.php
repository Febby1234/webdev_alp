<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pendaftar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- Back Button --}}
            <div class="mb-6">
                <a href="{{ route('admin.registrations.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Daftar Pendaftar
                </a>
            </div>

            {{-- Status & Actions --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $registration->registration_code }}</h3>
                            <p class="text-gray-600 mt-1">Terdaftar: {{ $registration->created_at->format('d F Y, H:i') }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <x-status-badge :status="$registration->status" class="text-base px-4 py-2" />

                            @if($registration->status == 'pending')
                            <form method="POST" action="{{ route('admin.registrations.approve', $registration->registration_id) }}" class="inline">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                    ✓ Setujui
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.registrations.reject', $registration->registration_id) }}" class="inline">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition"
                                        onclick="return confirm('Yakin ingin menolak pendaftar ini?')">
                                    ✗ Tolak
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Main Content --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Biodata --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900">Biodata Pribadi</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Nama Lengkap</label>
                                    <p class="text-gray-900 mt-1">{{ $registration->personalDetail->fullname }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Jenis Kelamin</label>
                                    <p class="text-gray-900 mt-1">{{ $registration->personalDetail->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Tempat, Tanggal Lahir</label>
                                    <p class="text-gray-900 mt-1">{{ $registration->personalDetail->place_of_birth }}, {{ date('d F Y', strtotime($registration->personalDetail->date_of_birth)) }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">No. Telepon</label>
                                    <p class="text-gray-900 mt-1">{{ $registration->personalDetail->phone }}</p>
                                </div>
                                <div class="col-span-2">
                                    <label class="text-sm font-medium text-gray-600">Alamat</label>
                                    <p class="text-gray-900 mt-1">{{ $registration->personalDetail->address }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Data Orang Tua --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900">Data Orang Tua</h3>
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <h4 class="font-semibold text-gray-800 mb-3">Ayah</h4>
                                    <div class="space-y-2">
                                        <div>
                                            <label class="text-sm text-gray-600">Nama</label>
                                            <p class="text-gray-900">{{ $registration->parent->father_name }}</p>
                                        </div>
                                        <div>
                                            <label class="text-sm text-gray-600">Pekerjaan</label>
                                            <p class="text-gray-900">{{ $registration->parent->father_job ?? '-' }}</p>
                                        </div>
                                        <div>
                                            <label class="text-sm text-gray-600">No. Telepon</label>
                                            <p class="text-gray-900">{{ $registration->parent->father_phone ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800 mb-3">Ibu</h4>
                                    <div class="space-y-2">
                                        <div>
                                            <label class="text-sm text-gray-600">Nama</label>
                                            <p class="text-gray-900">{{ $registration->parent->mother_name }}</p>
                                        </div>
                                        <div>
                                            <label class="text-sm text-gray-600">Pekerjaan</label>
                                            <p class="text-gray-900">{{ $registration->parent->mother_job ?? '-' }}</p>
                                        </div>
                                        <div>
                                            <label class="text-sm text-gray-600">No. Telepon</label>
                                            <p class="text-gray-900">{{ $registration->parent->mother_phone ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Asal Sekolah --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900">Asal Sekolah & Jurusan</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Nama Sekolah</label>
                                    <p class="text-gray-900 mt-1">{{ $registration->schoolOrigin->school_origin_name }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Tahun Lulus</label>
                                    <p class="text-gray-900 mt-1">{{ $registration->schoolOrigin->graduation_year }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Rata-rata Nilai</label>
                                    <p class="text-gray-900 mt-1">{{ $registration->schoolOrigin->average_grade ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Jurusan Dipilih</label>
                                    <p class="text-gray-900 mt-1 font-semibold">{{ $registration->major->majors_name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="space-y-6">
                    {{-- Documents Status --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900">Status Dokumen</h3>
                            <div class="space-y-3">
                                @foreach($registration->documents ?? [] as $doc)
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-700">{{ $doc->type }}</span>
                                    <x-status-badge :status="$doc->status" />
                                </div>
                                @endforeach
                            </div>
                            <a href="{{ route('admin.documents.verify') }}?user_id={{ $registration->user_id }}"
                               class="block mt-4 text-sm text-blue-600 hover:text-blue-800 font-medium text-center">
                                Lihat Semua Dokumen →
                            </a>
                        </div>
                    </div>

                    {{-- Payment Status --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900">Status Pembayaran</h3>
                            @if($registration->payment)
                            <div class="space-y-3">
                                <div>
                                    <label class="text-sm text-gray-600">Nominal</label>
                                    <p class="text-lg font-bold text-gray-900">Rp {{ number_format($registration->payment->amount, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <label class="text-sm text-gray-600">Status</label>
                                    <div class="mt-1">
                                        <x-status-badge :status="$registration->payment->status" />
                                    </div>
                                </div>
                            </div>
                            @else
                            <p class="text-gray-500 text-sm">Belum ada pembayaran</p>
                            @endif
                        </div>
                    </div>

                    {{-- Exam Info --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900">Info Ujian</h3>
                            @if($registration->schedule)
                            <div class="space-y-3 text-sm">
                                <div>
                                    <label class="text-gray-600">Jenis</label>
                                    <p class="text-gray-900 font-medium">{{ $registration->schedule->type }}</p>
                                </div>
                                <div>
                                    <label class="text-gray-600">Tanggal</label>
                                    <p class="text-gray-900">{{ date('d F Y', strtotime($registration->schedule->date)) }}</p>
                                </div>
                                <div>
                                    <label class="text-gray-600">Waktu</label>
                                    <p class="text-gray-900">{{ date('H:i', strtotime($registration->schedule->time)) }} WIB</p>
                                </div>
                                <div>
                                    <label class="text-gray-600">Lokasi</label>
                                    <p class="text-gray-900">{{ $registration->schedule->location }}</p>
                                </div>
                            </div>
                            @else
                            <p class="text-gray-500 text-sm">Belum ada jadwal ujian</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-main-layout>
