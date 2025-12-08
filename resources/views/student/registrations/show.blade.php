<x-main-layout>
    <x-slot name="title">Detail Pendaftaran</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Pendaftaran</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <x-back-button href="{{ route('student.dashboard') }}" />

            {{-- Status Alert --}}
            @if($registration->status == 'approved')
                <x-alert type="success">
                    <strong>Selamat!</strong> Pendaftaran Anda telah disetujui.
                </x-alert>
            @elseif($registration->status == 'pending')
                <x-alert type="warning">
                    <strong>Menunggu Verifikasi!</strong> Pendaftaran sedang dalam proses verifikasi.
                </x-alert>
            @elseif($registration->status == 'rejected')
                <x-alert type="error">
                    <strong>Ditolak!</strong> Silahkan hubungi admin untuk info lebih lanjut.
                </x-alert>
            @endif

            {{-- Kode Registrasi --}}
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg shadow-lg p-6 mb-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm opacity-90">Kode Registrasi Anda</p>
                        <h3 class="text-3xl font-bold tracking-wider mt-1">{{ $registration->registration_code }}</h3>
                        <p class="text-sm opacity-90 mt-2">Simpan kode ini untuk keperluan administrasi</p>
                    </div>
                    <x-status-badge :status="$registration->status" class="text-base px-4 py-2" />
                </div>
            </div>

            {{-- Biodata --}}
            <x-card title="Biodata Pribadi" class="mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><label class="text-sm font-medium text-gray-600">Nama</label><p class="text-gray-900 mt-1">{{ $registration->personalDetail->fullname }}</p></div>
                    <div><label class="text-sm font-medium text-gray-600">Jenis Kelamin</label><p class="text-gray-900 mt-1">{{ $registration->personalDetail->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</p></div>
                    <div><label class="text-sm font-medium text-gray-600">Tempat, Tanggal Lahir</label><p class="text-gray-900 mt-1">{{ $registration->personalDetail->place_of_birth }}, {{ date('d F Y', strtotime($registration->personalDetail->date_of_birth)) }}</p></div>
                    <div><label class="text-sm font-medium text-gray-600">No. Telepon</label><p class="text-gray-900 mt-1">{{ $registration->personalDetail->phone }}</p></div>
                    <div class="md:col-span-2"><label class="text-sm font-medium text-gray-600">Alamat</label><p class="text-gray-900 mt-1">{{ $registration->personalDetail->address }}</p></div>
                </div>
            </x-card>

            {{-- Data Orang Tua --}}
            <x-card title="Data Orang Tua" class="mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-3">Ayah</h4>
                        <div class="space-y-2">
                            <div><label class="text-sm text-gray-600">Nama</label><p class="text-gray-900">{{ $registration->parent->father_name }}</p></div>
                            <div><label class="text-sm text-gray-600">Pekerjaan</label><p class="text-gray-900">{{ $registration->parent->father_job ?? '-' }}</p></div>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-3">Ibu</h4>
                        <div class="space-y-2">
                            <div><label class="text-sm text-gray-600">Nama</label><p class="text-gray-900">{{ $registration->parent->mother_name }}</p></div>
                            <div><label class="text-sm text-gray-600">Pekerjaan</label><p class="text-gray-900">{{ $registration->parent->mother_job ?? '-' }}</p></div>
                        </div>
                    </div>
                </div>
            </x-card>

            {{-- Asal Sekolah --}}
            <x-card title="Asal Sekolah & Jurusan" class="mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><label class="text-sm font-medium text-gray-600">Nama Sekolah</label><p class="text-gray-900 mt-1">{{ $registration->schoolOrigin->school_origin_name }}</p></div>
                    <div><label class="text-sm font-medium text-gray-600">Tahun Lulus</label><p class="text-gray-900 mt-1">{{ $registration->schoolOrigin->graduation_year }}</p></div>
                    <div><label class="text-sm font-medium text-gray-600">Rata-rata Nilai</label><p class="text-gray-900 mt-1">{{ $registration->schoolOrigin->average_grade ?? '-' }}</p></div>
                    <div><label class="text-sm font-medium text-gray-600">Jurusan Dipilih</label><p class="text-gray-900 mt-1 font-semibold">{{ $registration->major->majors_name }}</p></div>
                </div>
            </x-card>

            {{-- Quick Actions --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <x-card-link href="{{ route('student.documents.index') }}" icon="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" title="Upload Dokumen" subtitle="Lengkapi berkas" />
                <x-card-link href="{{ route('student.payments.index') }}" icon="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" title="Pembayaran" subtitle="Lihat tagihan" />
                <x-card-link href="{{ route('student.exams.schedule') }}" icon="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" title="Jadwal Ujian" subtitle="Cek jadwal" />
            </div>

        </div>
    </div>
</x-main-layout>
