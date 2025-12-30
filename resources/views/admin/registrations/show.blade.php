<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pendaftar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            {{-- Back Button --}}
            <div class="mb-6">
                <a href="{{ route('admin.registrations.index') }}"
                   class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Daftar Pendaftar
                </a>
            </div>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="mb-6">
                    <x-alert type="success">{{ session('success') }}</x-alert>
                </div>
            @endif

            {{-- Status & Actions --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between flex-wrap gap-4">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $registration->registration_code }}</h3>
                            <p class="text-gray-600 mt-1">
                                Terdaftar: {{ $registration->created_at->format('d F Y, H:i') }}
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <x-status-badge :status="$registration->status" class="text-base px-4 py-2" />

                            @if(in_array($registration->status, ['pending', 'documents_verified', 'paid', 'finished']))
                            <form method="POST"
                                  action="{{ route('admin.registrations.updateStatus', $registration->id) }}"
                                  class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="{{ $registration->status == 'pending' ? 'documents_pending' : ($registration->status == 'finished' ? 'pass' : 'accepted') }}">
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ $registration->status == 'pending' ? 'Lanjutkan' : ($registration->status == 'finished' ? 'Luluskan' : 'Terima') }}
                                </button>
                            </form>

                            @if($registration->status == 'finished')
                            <form method="POST"
                                  action="{{ route('admin.registrations.updateStatus', $registration->id) }}"
                                  class="inline"
                                  onsubmit="return confirm('Yakin ingin menandai sebagai TIDAK LULUS?')">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="fail">
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Tidak Lulus
                                </button>
                            </form>
                            @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Main Content --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Biodata Pribadi --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Biodata Pribadi
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-xs font-medium text-gray-500 uppercase">Nama Lengkap</label>
                                    <p class="text-gray-900 font-medium mt-1">
                                        {{ $registration->personalDetail->fullname ?? '-' }}
                                    </p>
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-gray-500 uppercase">Jenis Kelamin</label>
                                    <p class="text-gray-900 mt-1">
                                        {{ ($registration->personalDetail->gender ?? '') == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                    </p>
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-gray-500 uppercase">Tempat Lahir</label>
                                    <p class="text-gray-900 mt-1">
                                        {{ $registration->personalDetail->place_of_birth ?? '-' }}
                                    </p>
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-gray-500 uppercase">Tanggal Lahir</label>
                                    <p class="text-gray-900 mt-1">
                                        {{ $registration->personalDetail->date_of_birth ? \Carbon\Carbon::parse($registration->personalDetail->date_of_birth)->format('d F Y') : '-' }}
                                    </p>
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-gray-500 uppercase">No. Telepon</label>
                                    <p class="text-gray-900 mt-1">
                                        {{ $registration->personalDetail->phone ?? '-' }}
                                    </p>
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-gray-500 uppercase">Email</label>
                                    <p class="text-gray-900 mt-1">
                                        {{ $registration->user->email ?? '-' }}
                                    </p>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="text-xs font-medium text-gray-500 uppercase">Alamat Lengkap</label>
                                    <p class="text-gray-900 mt-1">
                                        {{ $registration->personalDetail->address ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Data Orang Tua --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Data Orang Tua
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-3">
                                    <h4 class="font-semibold text-gray-800 mb-3 pb-2 border-b">Ayah</h4>
                                    <div>
                                        <label class="text-xs text-gray-500 uppercase">Nama</label>
                                        <p class="text-gray-900 font-medium">
                                            {{ $registration->parent->father_name ?? '-' }}
                                        </p>
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-500 uppercase">Pekerjaan</label>
                                        <p class="text-gray-900">
                                            {{ $registration->parent->father_job ?? '-' }}
                                        </p>
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-500 uppercase">No. Telepon</label>
                                        <p class="text-gray-900">
                                            {{ $registration->parent->father_phone ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="space-y-3">
                                    <h4 class="font-semibold text-gray-800 mb-3 pb-2 border-b">Ibu</h4>
                                    <div>
                                        <label class="text-xs text-gray-500 uppercase">Nama</label>
                                        <p class="text-gray-900 font-medium">
                                            {{ $registration->parent->mother_name ?? '-' }}
                                        </p>
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-500 uppercase">Pekerjaan</label>
                                        <p class="text-gray-900">
                                            {{ $registration->parent->mother_job ?? '-' }}
                                        </p>
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-500 uppercase">No. Telepon</label>
                                        <p class="text-gray-900">
                                            {{ $registration->parent->mother_phone ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Asal Sekolah & Jurusan --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                Asal Sekolah & Jurusan
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-xs font-medium text-gray-500 uppercase">Nama Sekolah</label>
                                    <p class="text-gray-900 font-medium mt-1">
                                        {{ $registration->schoolOrigin->school_name ?? '-' }}
                                    </p>
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-gray-500 uppercase">Tahun Lulus</label>
                                    <p class="text-gray-900 mt-1">
                                        {{ $registration->schoolOrigin->graduation_year ?? '-' }}
                                    </p>
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-gray-500 uppercase">Rata-rata Nilai</label>
                                    <p class="text-gray-900 mt-1">
                                        {{ $registration->schoolOrigin->average_grade ?? '-' }}
                                    </p>
                                </div>
                                <div>
                                    <label class="text-xs font-medium text-gray-500 uppercase">Jurusan Dipilih</label>
                                    <p class="text-lg text-blue-600 mt-1 font-semibold">
                                        {{ $registration->major->name ?? '-' }}
                                    </p>
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
                            <h3 class="text-lg font-semibold mb-4 text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Status Dokumen
                            </h3>
                            @if($registration->documents && $registration->documents->count() > 0)
                            <div class="space-y-3">
                                @foreach($registration->documents as $doc)
                                <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                                    <span class="text-sm text-gray-700 font-medium">{{ $doc->type }}</span>
                                    <x-status-badge :status="$doc->status" />
                                </div>
                                @endforeach
                            </div>
                            <a href="{{ route('admin.documents.index') }}?search={{ $registration->registration_code }}"
                               class="block mt-4 text-sm text-blue-600 hover:text-blue-800 font-medium text-center transition">
                                Lihat Semua Dokumen →
                            </a>
                            @else
                            <p class="text-gray-500 text-sm">Belum ada dokumen diupload</p>
                            @endif
                        </div>
                    </div>

                    {{-- Payment Status --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Status Pembayaran
                            </h3>
                            @if($registration->payment)
                            <div class="space-y-3">
                                <div>
                                    <label class="text-xs text-gray-500 uppercase">Nominal</label>
                                    <p class="text-2xl font-bold text-gray-900 mt-1">
                                        Rp {{ number_format($registration->payment->amount, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div>
                                    <label class="text-xs text-gray-500 uppercase">Status</label>
                                    <div class="mt-1">
                                        <x-status-badge :status="$registration->payment->status" />
                                    </div>
                                </div>
                                <a href="{{ route('admin.payments.show', $registration->payment->id) }}"
                                   class="block mt-4 text-sm text-blue-600 hover:text-blue-800 font-medium text-center transition">
                                    Lihat Detail Pembayaran →
                                </a>
                            </div>
                            @else
                            <p class="text-gray-500 text-sm">Belum ada pembayaran</p>
                            @endif
                        </div>
                    </div>

                    {{-- Exam Schedule --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Jadwal Ujian
                            </h3>
                            @if($registration->schedule)
                            <div class="space-y-3 text-sm">
                                <div>
                                    <label class="text-xs text-gray-500 uppercase">Jenis Ujian</label>
                                    <p class="text-gray-900 font-medium mt-1">{{ $registration->schedule->type }}</p>
                                </div>
                                <div>
                                    <label class="text-xs text-gray-500 uppercase">Tanggal</label>
                                    <p class="text-gray-900 mt-1">
                                        {{ \Carbon\Carbon::parse($registration->schedule->date)->format('d F Y') }}
                                    </p>
                                </div>
                                <div>
                                    <label class="text-xs text-gray-500 uppercase">Waktu</label>
                                    <p class="text-gray-900 mt-1">
                                        {{ \Carbon\Carbon::parse($registration->schedule->time)->format('H:i') }} WIB
                                    </p>
                                </div>
                                <div>
                                    <label class="text-xs text-gray-500 uppercase">Lokasi</label>
                                    <p class="text-gray-900 mt-1">{{ $registration->schedule->location }}</p>
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
