<x-main-layout>
    <x-slot name="title">Detail Pendaftaran</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Pendaftaran</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Back Button --}}
            <div class="mb-6">
                <a href="{{ route('student.dashboard') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>

            {{-- Status Alert --}}
            @if($registration->status == 'accepted')
                <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <p class="ml-3 text-sm text-green-800"><strong>Selamat!</strong> Pendaftaran Anda telah diterima.</p>
                    </div>
                </div>
            @elseif($registration->status == 'pending' || $registration->status == 'documents_pending')
                <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <p class="ml-3 text-sm text-yellow-800"><strong>Menunggu Verifikasi!</strong> Pendaftaran sedang dalam proses verifikasi.</p>
                    </div>
                </div>
            @elseif($registration->status == 'fail')
                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <p class="ml-3 text-sm text-red-800"><strong>Tidak Lulus!</strong> Silahkan hubungi admin untuk info lebih lanjut.</p>
                    </div>
                </div>
            @endif

            {{-- Kode Registrasi --}}
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg shadow-lg p-6 mb-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm opacity-90">Kode Registrasi Anda</p>
                        <h3 class="text-3xl font-bold tracking-wider mt-1">{{ $registration->registration_code }}</h3>
                        <p class="text-sm opacity-90 mt-2">Simpan kode ini untuk keperluan administrasi</p>
                    </div>
                    @php
                        $s = $registration->status ?? 'pending';
                        $badges = [
                            'pending' => ['bg' => 'bg-yellow-500', 'label' => 'Pending'],
                            'documents_pending' => ['bg' => 'bg-orange-500', 'label' => 'Dokumen Pending'],
                            'documents_verified' => ['bg' => 'bg-blue-500', 'label' => 'Dokumen Verified'],
                            'payment_pending' => ['bg' => 'bg-purple-500', 'label' => 'Pembayaran Pending'],
                            'paid' => ['bg' => 'bg-indigo-500', 'label' => 'Lunas'],
                            'exam_scheduled' => ['bg' => 'bg-cyan-500', 'label' => 'Ujian Terjadwal'],
                            'finished' => ['bg' => 'bg-gray-500', 'label' => 'Selesai'],
                            'pass' => ['bg' => 'bg-green-500', 'label' => 'Lulus'],
                            'fail' => ['bg' => 'bg-red-500', 'label' => 'Tidak Lulus'],
                            'accepted' => ['bg' => 'bg-green-500', 'label' => 'Diterima'],
                        ];
                        $b = $badges[$s] ?? $badges['pending'];
                    @endphp
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium {{ $b['bg'] }} text-white">
                        {{ $b['label'] }}
                    </span>
                </div>
            </div>

            {{-- Biodata --}}
            @if($registration->personalDetail)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Biodata Pribadi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-600">Nama</label>
                            <p class="text-gray-900 mt-1">{{ $registration->personalDetail->full_name ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Jenis Kelamin</label>
                            <p class="text-gray-900 mt-1">{{ $registration->personalDetail->gender ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Tempat, Tanggal Lahir</label>
                            <p class="text-gray-900 mt-1">
                                {{ $registration->personalDetail->birth_place ?? '-' }},
                                {{ $registration->personalDetail->birth_date ? $registration->personalDetail->birth_date->format('d F Y') : '-' }}
                            </p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">No. Telepon</label>
                            <p class="text-gray-900 mt-1">{{ $registration->personalDetail->phone ?? '-' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-sm font-medium text-gray-600">Alamat</label>
                            <p class="text-gray-900 mt-1">{{ $registration->personalDetail->address ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Data Orang Tua --}}
            @if($registration->parents)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Orang Tua</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-3">Ayah</h4>
                            <div class="space-y-2">
                                <div>
                                    <label class="text-sm text-gray-600">Nama</label>
                                    <p class="text-gray-900">{{ $registration->parents->father_name ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm text-gray-600">Pekerjaan</label>
                                    <p class="text-gray-900">{{ $registration->parents->father_job ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm text-gray-600">No. Telepon</label>
                                    <p class="text-gray-900">{{ $registration->parents->father_phone ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-3">Ibu</h4>
                            <div class="space-y-2">
                                <div>
                                    <label class="text-sm text-gray-600">Nama</label>
                                    <p class="text-gray-900">{{ $registration->parents->mother_name ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm text-gray-600">Pekerjaan</label>
                                    <p class="text-gray-900">{{ $registration->parents->mother_job ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm text-gray-600">No. Telepon</label>
                                    <p class="text-gray-900">{{ $registration->parents->mother_phone ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Asal Sekolah --}}
            @if($registration->schoolOrigin)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Asal Sekolah & Jurusan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-600">Nama Sekolah</label>
                            <p class="text-gray-900 mt-1">{{ $registration->schoolOrigin->school_origin_name ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Tahun Lulus</label>
                            <p class="text-gray-900 mt-1">{{ $registration->schoolOrigin->graduation_year ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Rata-rata Nilai</label>
                            <p class="text-gray-900 mt-1">{{ $registration->schoolOrigin->average_grade ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Jurusan Dipilih</label>
                            <p class="text-gray-900 mt-1 font-semibold">{{ $registration->major->name ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Quick Actions --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('student.documents.index') }}"
                   class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition p-6">
                    <div class="flex items-center">
                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <div class="ml-4">
                            <h4 class="font-semibold text-gray-900">Upload Dokumen</h4>
                            <p class="text-sm text-gray-600">Lengkapi berkas</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('student.payments.index') }}"
                   class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition p-6">
                    <div class="flex items-center">
                        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <div class="ml-4">
                            <h4 class="font-semibold text-gray-900">Pembayaran</h4>
                            <p class="text-sm text-gray-600">Lihat tagihan</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('student.exams.schedule') }}"
                   class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition p-6">
                    <div class="flex items-center">
                        <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <div class="ml-4">
                            <h4 class="font-semibold text-gray-900">Jadwal Ujian</h4>
                            <p class="text-sm text-gray-600">Cek jadwal</p>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>
</x-main-layout>
