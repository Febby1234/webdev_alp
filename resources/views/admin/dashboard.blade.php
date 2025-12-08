{{-- resources/views/admin/dashboard.blade.php --}}
<x-app-layout>
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
                        <h3 class="text-2xl font-bold">Selamat Datang, Admin!</h3>
                        <p class="text-blue-100 mt-1">Dashboard Penerimaan Mahasiswa Baru {{ date('Y') }}</p>
                    </div>
                    <div>
                        <svg class="w-16 h-16 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Statistics Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                {{-- Total Pendaftar --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-600">Total Pendaftar</p>
                                <h3 class="text-2xl font-bold text-gray-900">{{ $total_registrations ?? 0 }}</h3>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.registrations.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                Lihat Semua →
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Pending Verification --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-100 rounded-lg p-3">
                                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-600">Pending Verifikasi</p>
                                <h3 class="text-2xl font-bold text-gray-900">{{ $pending_verifications ?? 0 }}</h3>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.registrations.index', ['status' => 'pending']) }}" class="text-sm text-yellow-600 hover:text-yellow-800 font-medium">
                                Verifikasi Sekarang →
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Approved --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-600">Disetujui</p>
                                <h3 class="text-2xl font-bold text-gray-900">{{ $approved_registrations ?? 0 }}</h3>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.registrations.index', ['status' => 'approved']) }}" class="text-sm text-green-600 hover:text-green-800 font-medium">
                                Lihat Detail →
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Pending Payments --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-600">Pending Pembayaran</p>
                                <h3 class="text-2xl font-bold text-gray-900">{{ $pending_payments ?? 0 }}</h3>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.payments.index') }}" class="text-sm text-purple-600 hover:text-purple-800 font-medium">
                                Verifikasi Pembayaran →
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                {{-- Chart: Pendaftar per Jurusan --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900">Pendaftar per Jurusan</h3>
                        <div class="space-y-3">
                            @forelse($registrations_by_major ?? [] as $major)
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">{{ $major->name }}</span>
                                    <span class="text-sm text-gray-600">{{ $major->count }} / {{ $major->quota }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($major->count / $major->quota) * 100 }}%"></div>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500 text-center py-4">Belum ada data</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Recent Registrations --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900">Pendaftar Terbaru</h3>
                        <div class="space-y-3">
                            @forelse($recent_registrations ?? [] as $registration)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold">
                                        {{ substr($registration->personalDetail->fullname ?? 'U', 0, 1) }}
                                    </div>
                                    <div class="ml-3">
                                        <p class="font-medium text-gray-900">{{ $registration->personalDetail->fullname ?? '-' }}</p>
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
                        <div class="mt-4">
                            <a href="{{ route('admin.registrations.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                Lihat Semua →
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions & Pending Documents --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Quick Actions --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900">Quick Actions</h3>
                        <div class="space-y-3">
                            <a href="{{ route('admin.announcements.create') }}" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="font-medium text-gray-900">Buat Pengumuman</p>
                                    <p class="text-sm text-gray-600">Tambah pengumuman baru</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.schedules.create') }}" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="font-medium text-gray-900">Buat Jadwal Ujian</p>
                                    <p class="text-sm text-gray-600">Atur jadwal ujian baru</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.majors.create') }}" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="font-medium text-gray-900">Tambah Jurusan</p>
                                    <p class="text-sm text-gray-600">Kelola jurusan tersedia</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.reports.export') }}" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="font-medium text-gray-900">Export Laporan</p>
                                    <p class="text-sm text-gray-600">Download data Excel</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Pending Documents Verification --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900">Dokumen Menunggu Verifikasi</h3>
                        <div class="space-y-3">
                            @forelse($pending_documents ?? [] as $document)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <div class="ml-3">
                                        <p class="font-medium text-gray-900">{{ $document->document_name }}</p>
                                        <p class="text-xs text-gray-600">{{ $document->user->name ?? '-' }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('admin.documents.verify', $document->id) }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                    Verifikasi →
                                </a>
                            </div>
                            @empty
                            <p class="text-gray-500 text-center py-4">Tidak ada dokumen pending</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
