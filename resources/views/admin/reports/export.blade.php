<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Export Laporan') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-6 text-gray-900">Pilih Data yang Akan Di-export</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Export Pendaftar --}}
                        <form method="POST" action="{{ route('admin.reports.export.registrations') }}" class="border rounded-lg p-6 hover:shadow-lg transition">
                            @csrf
                            <div class="flex items-center mb-4">
                                <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <div class="ml-4">
                                    <h4 class="font-semibold text-gray-900">Data Pendaftar</h4>
                                    <p class="text-sm text-gray-600">Export semua data pendaftar</p>
                                </div>
                            </div>
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Download Excel
                            </button>
                        </form>

                        {{-- Export Pembayaran --}}
                        <form method="POST" action="{{ route('admin.reports.export.payments') }}" class="border rounded-lg p-6 hover:shadow-lg transition">
                            @csrf
                            <div class="flex items-center mb-4">
                                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <div class="ml-4">
                                    <h4 class="font-semibold text-gray-900">Data Pembayaran</h4>
                                    <p class="text-sm text-gray-600">Export semua data pembayaran</p>
                                </div>
                            </div>
                            <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                Download Excel
                            </button>
                        </form>

                        {{-- Export Hasil Ujian --}}
                        <form method="POST" action="{{ route('admin.reports.export.exams') }}" class="border rounded-lg p-6 hover:shadow-lg transition">
                            @csrf
                            <div class="flex items-center mb-4">
                                <svg class="w-12 h-12 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="ml-4">
                                    <h4 class="font-semibold text-gray-900">Hasil Ujian</h4>
                                    <p class="text-sm text-gray-600">Export hasil ujian pendaftar</p>
                                </div>
                            </div>
                            <button type="submit" class="w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                                Download Excel
                            </button>
                        </form>

                        {{-- Export Jurusan --}}
                        <form method="POST" action="{{ route('admin.reports.export.majors') }}" class="border rounded-lg p-6 hover:shadow-lg transition">
                            @csrf
                            <div class="flex items-center mb-4">
                                <svg class="w-12 h-12 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <div class="ml-4">
                                    <h4 class="font-semibold text-gray-900">Data Jurusan</h4>
                                    <p class="text-sm text-gray-600">Export data pendaftar per jurusan</p>
                                </div>
                            </div>
                            <button type="submit" class="w-full px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700">
                                Download Excel
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>
