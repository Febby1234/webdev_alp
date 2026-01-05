<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Welcome Banner --}}
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg shadow-lg p-6 mb-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold">Selamat Datang, {{ auth()->user()->name }}!</h3>
                        <p class="text-blue-100 mt-1">Dashboard Penerimaan Mahasiswa Baru {{ date('Y') }}</p>
                    </div>
                </div>
            </div>

            {{-- Statistics Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                {{-- Total Pendaftar --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-600 font-medium">Total Pendaftar</p>
                                <h3 class="text-3xl font-bold text-gray-900">{{ $stats['total_registrations'] ?? 0 }}</h3>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.registrations.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium inline-flex items-center">
                                Lihat Semua
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Pending Verification --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-600 font-medium">Pending Verifikasi</p>
                                <h3 class="text-3xl font-bold text-gray-900">{{ $stats['pending_verifications'] ?? 0 }}</h3>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.registrations.index', ['status' => 'pending']) }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium inline-flex items-center">
                                Verifikasi Sekarang
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Approved --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-600 font-medium">Lulus Seleksi</p>
                                <h3 class="text-3xl font-bold text-gray-900">{{ $stats['pass'] ?? 0 }}</h3>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.registrations.index', ['status' => 'accepted']) }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium inline-flex items-center">
                                Lihat Detail
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Pending Payments --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-600 font-medium">Pending Pembayaran</p>
                                <h3 class="text-3xl font-bold text-gray-900">{{ $stats['pending_payments'] ?? 0 }}</h3>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.registrations.index', ['status' => 'paid']) }}"
                            class="text-sm text-blue-600 hover:text-blue-800 font-medium inline-flex items-center">
                                Verifikasi Pembayaran
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

                {{-- Recent Registrations --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Pendaftar Terbaru
                        </h3>
                        <div class="space-y-3">
                            @forelse($recent_registrations ?? [] as $registration)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex items-center">
                                    <div class="ml-3">
                                        <p class="font-medium text-gray-900 text-sm">
                                            {{ $registration->personalDetail->fullname ?? $registration->user->name ?? '-' }}
                                        </p>
                                        <p class="text-xs text-gray-600">{{ $registration->registration_code }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <x-status-badge :status="$registration->status" />
                                    <p class="text-xs text-gray-500 mt-1">{{ $registration->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500 text-center py-4">Belum ada pendaftar</p>
                            @endforelse
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.registrations.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium inline-flex items-center">
                                Lihat Semua
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Quick Actions
                        </h3>
                        <div class="space-y-2">
                            <a href="{{ route('admin.announcements.create') }}" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition group">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                                    </svg>
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="font-medium text-gray-900 group-hover:text-blue-600">Buat Pengumuman</p>
                                    <p class="text-xs text-gray-600">Tambah pengumuman baru</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.schedules.create') }}" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-green-50 hover:border-green-300 transition group">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="font-medium text-gray-900 group-hover:text-blue-600">Buat Jadwal Ujian</p>
                                    <p class="text-xs text-gray-600">Atur jadwal ujian baru</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.majors.create') }}" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition group">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="font-medium text-gray-900 group-hover:text-blue-600">Tambah Jurusan</p>
                                    <p class="text-xs text-gray-600">Kelola jurusan tersedia</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.reports.export') }}" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition group">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="font-medium text-gray-900 group-hover:text-blue-600">Export Laporan</p>
                                    <p class="text-xs text-gray-600">Download data Excel</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

                {{-- Pending Documents Verification --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Dokumen Menunggu Verifikasi
                        </h3>
                        <div class="space-y-2">
                            @forelse($pending_documents ?? [] as $document)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex items-center flex-1">
                                    <svg class="w-8 h-8 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <div class="ml-3">
                                        <p class="font-medium text-gray-900 text-sm">{{ $document->type }}</p>
                                        <p class="text-xs text-gray-600">
                                            {{ $document->registration->personalDetail->fullname ?? $document->registration->user->name ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                                <a href="{{ route('admin.documents.show', $document->id) }}"
                                   class="text-sm text-blue-600 hover:text-blue-800 font-medium whitespace-nowrap ml-3 inline-flex items-center">
                                    Verifikasi
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                            @empty
                            <p class="text-gray-500 text-center py-8">Tidak ada dokumen pending</p>
                            @endforelse
                        </div>
                        @if(count($pending_documents ?? []) > 0)
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.documents.index', ['status' => 'pending']) }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium inline-flex items-center">
                                Lihat Semua Dokumen
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-main-layout>
