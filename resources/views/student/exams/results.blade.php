<x-main-layout>
    <x-slot name="title">Hasil Ujian</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Hasil Ujian</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <x-back-button href="{{ route('student.exams.schedule') }}" text="Kembali ke Jadwal Ujian" />

            @if($exam_result)
                {{-- Results Summary --}}
                <div class="bg-gradient-to-r from-green-600 to-green-700 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-8 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm opacity-90 mb-2">Total Nilai Akhir</p>
                                <h3 class="text-5xl font-bold">{{ $exam_result->score }}</h3>
                                <p class="text-sm opacity-90 mt-3">Status: <span class="font-semibold">{{ $exam_result->status == 'passed' ? 'LULUS' : 'TIDAK LULUS' }}</span></p>
                            </div>
                            <div>
                                <svg class="w-24 h-24 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Detailed Results --}}
                <x-card title="Detail Hasil Ujian" class="mb-6">
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div><label class="text-sm font-medium text-gray-600">Nilai Ujian</label><p class="text-2xl font-bold text-gray-900">{{ $exam_result->score }}</p></div>
                            <div><label class="text-sm font-medium text-gray-600">Status</label><div class="mt-1"><x-status-badge :status="$exam_result->status" class="text-sm px-3 py-1" /></div></div>
                        </div>

                        @if($exam_result->notes)
                        <div class="mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                            <label class="text-sm font-semibold text-blue-900">Catatan:</label>
                            <p class="text-sm text-blue-800 mt-1">{{ $exam_result->notes }}</p>
                        </div>
                        @endif
                    </div>
                </x-card>

                {{-- Next Steps --}}
                <x-card title="Langkah Selanjutnya">
                    @if($exam_result->status == 'passed')
                        <x-alert type="success">
                            <strong>Selamat!</strong> Anda telah lulus ujian. Silakan tunggu pengumuman lebih lanjut untuk proses daftar ulang.
                        </x-alert>
                    @else
                        <x-alert type="error">
                            Mohon maaf, Anda belum lulus ujian kali ini. Silakan hubungi admin untuk informasi lebih lanjut.
                        </x-alert>
                    @endif
                </x-card>

            @else
                {{-- No Results Yet --}}
                <x-card>
                    <div class="p-12 text-center">
                        <svg class="w-20 h-20 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Hasil Ujian Belum Tersedia</h3>
                        <p class="text-gray-600 mb-6">Hasil ujian Anda akan ditampilkan di sini setelah proses penilaian selesai</p>
                        <a href="{{ route('student.exams.schedule') }}" class="inline-flex items-center px-5 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">Lihat Jadwal Ujian</a>
                    </div>
                </x-card>
            @endif

        </div>
    </div>
</x-main-layout>
