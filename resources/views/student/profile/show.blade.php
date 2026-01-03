<x-main-layout>
    <x-slot name="title">Profil Saya</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Profil Saya</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <div class="flex">
                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <p class="ml-3 text-sm text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            {{-- Profile Header --}}
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <div class="flex items-center">
                        <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center text-3xl font-bold text-blue-600 shadow-lg">
                            {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="ml-6 text-white">
                            <h3 class="text-2xl font-bold">{{ $user->name ?? 'Nama Pengguna' }}</h3>
                            <p class="text-blue-100 mt-1">{{ $user->email ?? 'email@example.com' }}</p>
                            <div class="mt-3 flex gap-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white text-blue-700">
                                    {{ ucfirst($user->role ?? 'Student') }}
                                </span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-500 text-white">
                                    Aktif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Account Info --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Informasi Akun</h3>
                        <a href="{{ route('student.profile.edit') }}"
                            class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 font-medium">
                            Edit Profil
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm font-medium text-gray-600">Nama Lengkap</label>
                            <p class="text-gray-900 mt-1 font-semibold">{{ $user->name ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Email</label>
                            <p class="text-gray-900 mt-1">{{ $user->email ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Role</label>
                            <p class="text-gray-900 mt-1">{{ ucfirst($user->role ?? 'Student') }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Tanggal Bergabung</label>
                            <p class="text-gray-900 mt-1">
                                {{ $user->created_at ? $user->created_at->format('d F Y') : '-' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Personal Info --}}
            @if(isset($personalDetail) && $personalDetail)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Biodata Pribadi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm font-medium text-gray-600">Nama Lengkap</label>
                            <p class="text-gray-900 mt-1">{{ $personalDetail->full_name ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Jenis Kelamin</label>
                            <p class="text-gray-900 mt-1">{{ $personalDetail->gender ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Tempat Lahir</label>
                            <p class="text-gray-900 mt-1">{{ $personalDetail->birth_place ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Tanggal Lahir</label>
                            <p class="text-gray-900 mt-1">
                                {{ $personalDetail->birth_date ? $personalDetail->birth_date->format('d F Y') : '-' }}
                            </p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-sm font-medium text-gray-600">Alamat</label>
                            <p class="text-gray-900 mt-1">{{ $personalDetail->address ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">No. Telepon</label>
                            <p class="text-gray-900 mt-1">{{ $personalDetail->phone ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Registration Status --}}
            @if(isset($registration) && $registration)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Status Pendaftaran</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm font-medium text-gray-600">Kode Registrasi</label>
                            <p class="text-gray-900 mt-1 font-mono font-bold text-lg">
                                {{ $registration->registration_code ?? '-' }}
                            </p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Status</label>
                            <div class="mt-1">
                                @php
                                    $s = $registration->status ?? 'pending';
                                    $badges = [
                                        'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'label' => 'Pending'],
                                        'documents_pending' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-800', 'label' => 'Dokumen Pending'],
                                        'documents_verified' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'label' => 'Dokumen Verified'],
                                        'payment_pending' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800', 'label' => 'Pembayaran Pending'],
                                        'paid' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-800', 'label' => 'Lunas'],
                                        'exam_scheduled' => ['bg' => 'bg-cyan-100', 'text' => 'text-cyan-800', 'label' => 'Ujian Terjadwal'],
                                        'finished' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'label' => 'Selesai'],
                                        'pass' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Lulus'],
                                        'fail' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' => 'Tidak Lulus'],
                                        'accepted' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Diterima'],
                                    ];
                                    $b = $badges[$s] ?? $badges['pending'];
                                @endphp
                                <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium {{ $b['bg'] }} {{ $b['text'] }}">
                                    {{ $b['label'] }}
                                </span>
                            </div>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Jurusan Dipilih</label>
                            <p class="text-gray-900 mt-1">{{ $registration->major->name ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Tanggal Daftar</label>
                            <p class="text-gray-900 mt-1">
                                {{ $registration->created_at ? $registration->created_at->format('d F Y') : '-' }}
                            </p>
                        </div>
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('student.registration.show') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-sm">
                            Lihat Detail Pendaftaran
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endif

            {{-- Account Actions --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Pengaturan Akun</h3>
                    <div class="space-y-3">
                        <a href="{{ route('student.profile.edit') }}"
                            class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                <div class="ml-3">
                                    <p class="font-medium text-gray-900">Edit Profil</p>
                                    <p class="text-sm text-gray-600">Ubah informasi akun Anda</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center justify-between p-4 border border-red-200 rounded-lg hover:bg-red-50 transition text-left">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    <div class="ml-3">
                                        <p class="font-medium text-red-600">Keluar</p>
                                        <p class="text-sm text-red-500">Logout dari akun Anda</p>
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>
