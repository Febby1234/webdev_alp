<x-main-layout>
    <x-slot name="title">Hasil Ujian</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Hasil Ujian</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Back Button --}}
            <div class="mb-6">
                <a href="{{ route('student.exams.schedule') }}"
                   class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Jadwal Ujian
                </a>
            </div>

            @if($exam_result)
                {{-- Results Summary Card --}}
                <div class="bg-gradient-to-r from-{{ $exam_result->status === 'pass' ? 'green' : 'red' }}-600 to-{{ $exam_result->status === 'pass' ? 'green' : 'red' }}-700 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-8 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm opacity-90 mb-2">Total Nilai Akhir</p>
                                <h3 class="text-6xl font-bold mb-4">{{ number_format($exam_result->final_score, 1) }}</h3>
                                <div class="flex items-center">
                                    @if($exam_result->status === 'pass')
                                    <span class="px-4 py-2 bg-white bg-opacity-20 rounded-lg font-semibold text-lg">
                                        ✓ LULUS
                                    </span>
                                    @else
                                    <span class="px-4 py-2 bg-white bg-opacity-20 rounded-lg font-semibold text-lg">
                                        ✗ TIDAK LULUS
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                @if($exam_result->status === 'pass')
                                <svg class="w-32 h-32 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                @else
                                <svg class="w-32 h-32 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Score Breakdown --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Rincian Nilai</h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            {{-- Written Test --}}
                            <div class="text-center p-4 bg-blue-50 rounded-lg">
                                <svg class="w-8 h-8 mx-auto text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="text-sm text-gray-600 mb-1">Ujian Tertulis</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $exam_result->written_score ?? 0 }}</p>
                            </div>

                            {{-- Interview --}}
                            <div class="text-center p-4 bg-green-50 rounded-lg">
                                <svg class="w-8 h-8 mx-auto text-green-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                                </svg>
                                <p class="text-sm text-gray-600 mb-1">Wawancara</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $exam_result->interview_score ?? 0 }}</p>
                            </div>

                            {{-- Final Score --}}
                            <div class="text-center p-4 bg-purple-50 rounded-lg border-2 border-purple-300">
                                <svg class="w-8 h-8 mx-auto text-purple-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-sm text-gray-600 mb-1">Nilai Akhir</p>
                                <p class="text-3xl font-bold text-purple-900">{{ number_format($exam_result->final_score, 1) }}</p>
                            </div>
                        </div>

                        {{-- Pass Grade Info --}}
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Nilai Minimum Kelulusan:</span>
                                <span class="text-lg font-bold text-gray-900">{{ $exam_result->passing_grade ?? 70 }}</span>
                            </div>
                        </div>

                        {{-- Notes --}}
                        @if($exam_result->notes)
                        <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <div class="flex">
                                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div class="ml-3">
                                    <h4 class="text-sm font-semibold text-blue-900">Catatan dari Tim Penguji:</h4>
                                    <p class="text-sm text-blue-800 mt-1">{{ $exam_result->notes }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Next Steps Card --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Langkah Selanjutnya</h3>

                        @if($exam_result->status === 'pass')
                        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                            <div class="flex">
                                <svg class="w-6 h-6 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div class="ml-4">
                                    <h4 class="text-lg font-semibold text-green-900 mb-2">Selamat! Anda Dinyatakan Lulus</h4>
                                    <p class="text-green-800 mb-4">
                                        Anda telah berhasil melewati tahap seleksi. Silakan tunggu pengumuman resmi melalui email atau cek dashboard secara berkala untuk informasi proses daftar ulang.
                                    </p>
                                    <ul class="space-y-2 text-sm text-green-800">
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>Tunggu email konfirmasi dari kami</span>
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>Siapkan dokumen yang diperlukan untuk daftar ulang</span>
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>Pantau terus dashboard dan email Anda</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                            <div class="flex">
                                <svg class="w-6 h-6 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div class="ml-4">
                                    <h4 class="text-lg font-semibold text-red-900 mb-2">Mohon Maaf</h4>
                                    <p class="text-red-800 mb-4">
                                        Berdasarkan hasil evaluasi, nilai Anda belum mencapai standar kelulusan yang ditetapkan.
                                    </p>
                                    <ul class="space-y-2 text-sm text-red-800">
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>Anda dapat mencoba mendaftar kembali di gelombang berikutnya</span>
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>Hubungi admin untuk informasi lebih lanjut</span>
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>Tetap semangat dan jangan menyerah!</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

            @else
                {{-- No Results Card --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Hasil Ujian Belum Tersedia</h3>
                        <p class="text-gray-600 mb-8">
                            Hasil ujian Anda akan ditampilkan di sini setelah proses penilaian selesai.<br>
                            Proses penilaian biasanya memakan waktu 3-7 hari kerja.
                        </p>
                        <div class="flex justify-center gap-4">
                            <a href="{{ route('student.exams.schedule') }}"
                               class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-sm">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Lihat Jadwal Ujian
                            </a>
                            <a href="{{ route('student.dashboard') }}"
                               class="inline-flex items-center px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition">
                                Kembali ke Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-main-layout>
