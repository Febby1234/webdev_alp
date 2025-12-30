<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Export Laporan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- Back Button --}}
            <div class="mb-6">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="mb-6">
                    <x-alert type="success">{{ session('success') }}</x-alert>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-2xl font-semibold text-gray-900">Download Laporan</h3>
                        <p class="text-gray-600 mt-2">Pilih jenis data yang ingin Anda export ke format Excel</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Export Pendaftar --}}
                        <a href="{{ route('admin.reports.registrations') }}"
                           class="block border-2 border-gray-200 rounded-lg p-6 hover:border-blue-500 hover:shadow-lg transition group">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition">
                                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <h4 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition">
                                        Data Pendaftar
                                    </h4>
                                    <p class="text-sm text-gray-600 mt-1">
                                        Export semua data pendaftar termasuk biodata lengkap, status, dan jurusan pilihan
                                    </p>
                                    <div class="mt-4 flex items-center text-sm text-blue-600 font-medium">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Download Excel
                                    </div>
                                </div>
                            </div>
                        </a>

                        {{-- Export Pembayaran --}}
                        <a href="{{ route('admin.reports.payments') }}"
                           class="block border-2 border-gray-200 rounded-lg p-6 hover:border-green-500 hover:shadow-lg transition group">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition">
                                        <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <h4 class="text-lg font-semibold text-gray-900 group-hover:text-green-600 transition">
                                        Data Pembayaran
                                    </h4>
                                    <p class="text-sm text-gray-600 mt-1">
                                        Export semua transaksi pembayaran dengan detail nominal, tanggal, dan status verifikasi
                                    </p>
                                    <div class="mt-4 flex items-center text-sm text-green-600 font-medium">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Download Excel
                                    </div>
                                </div>
                            </div>
                        </a>

                        {{-- Export Hasil Ujian --}}
                        <a href="{{ route('admin.reports.exams') }}"
                           class="block border-2 border-gray-200 rounded-lg p-6 hover:border-purple-500 hover:shadow-lg transition group">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition">
                                        <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <h4 class="text-lg font-semibold text-gray-900 group-hover:text-purple-600 transition">
                                        Hasil Ujian
                                    </h4>
                                    <p class="text-sm text-gray-600 mt-1">
                                        Export hasil ujian seleksi pendaftar termasuk nilai, jadwal, dan status kelulusan
                                    </p>
                                    <div class="mt-4 flex items-center text-sm text-purple-600 font-medium">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Download Excel
                                    </div>
                                </div>
                            </div>
                        </a>

                        {{-- Export Per Jurusan --}}
                        <a href="{{ route('admin.reports.majors') }}"
                           class="block border-2 border-gray-200 rounded-lg p-6 hover:border-orange-500 hover:shadow-lg transition group">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center group-hover:bg-orange-200 transition">
                                        <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <h4 class="text-lg font-semibold text-gray-900 group-hover:text-orange-600 transition">
                                        Data Per Jurusan
                                    </h4>
                                    <p class="text-sm text-gray-600 mt-1">
                                        Export rekapitulasi pendaftar berdasarkan jurusan dengan statistik lengkap
                                    </p>
                                    <div class="mt-4 flex items-center text-sm text-orange-600 font-medium">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Download Excel
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    {{-- Info Box --}}
                    <div class="mt-8 bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                        <div class="flex">
                            <svg class="h-5 w-5 text-blue-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    <span class="font-medium">Tips:</span> Semua data akan diexport dalam format Microsoft Excel (.xlsx).
                                    File dapat dibuka menggunakan Microsoft Excel, Google Sheets, atau aplikasi spreadsheet lainnya.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-main-layout>
