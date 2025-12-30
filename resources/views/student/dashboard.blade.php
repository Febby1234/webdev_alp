<x-main-layout>
    <x-slot name="title">Dashboard Mahasiswa</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Mahasiswa</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Progress Bar --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Progress Pendaftaran</h3>
                    <div class="flex items-center justify-between">
                        @php
                            $steps = ['', 'Biodata', 'Orang Tua', 'Sekolah', 'Dokumen', 'Bayar'];
                            $current = $registration_step ?? 1;
                        @endphp
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i > 1)
                                <div class="flex-1 h-1 {{ $current >= $i ? 'bg-blue-600' : 'bg-gray-300' }}"></div>
                            @endif
                            <div class="flex flex-col items-center flex-1">
                                <div
                                    class="w-10 h-10 rounded-full {{ $current >= $i ? 'bg-blue-600' : 'bg-gray-300' }} flex items-center justify-center text-white font-bold">
                                    {{ $i }}</div>
                                <span class="text-xs sm:text-sm mt-2 text-center">{{ $steps[$i] }}</span>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <a href="{{ route('student.registration.show') }}"
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition">
                    <div class="p-6">
                        <div class="flex items-center">
                            <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <div class="ml-4 flex-1">
                                <h4 class="font-semibold text-gray-900">Status Pendaftaran</h4>
                                @php
                                    $s = $registration_status ?? 'pending';
                                    $badges = ['pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'label' => 'Pending'], 'verified' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'label' => 'Verified'], 'accepted' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Accepted']];
                                    $b = $badges[$s] ?? $badges['pending'];
                                @endphp
                                <span
                                    class="inline-flex px-2 py-1 rounded text-xs font-medium {{ $b['bg'] }} {{ $b['text'] }} mt-2">{{ $b['label'] }}</span>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="{{ route('student.documents.index') }}"
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition">
                    <div class="p-6">
                        <div class="flex items-center">
                            <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <div class="ml-4 flex-1">
                                <h4 class="font-semibold text-gray-900">Upload Dokumen</h4>
                                <p class="text-sm text-gray-600 mt-1">{{ $documents_uploaded ?? 0 }} /
                                    {{ $total_documents ?? 5 }} Dokumen</p>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="{{ route('student.exams.schedule') }}"
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition">
                    <div class="p-6">
                        <div class="flex items-center">
                            <svg class="w-12 h-12 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <div class="ml-4 flex-1">
                                <h4 class="font-semibold text-gray-900">Jadwal Ujian</h4>
                                <p class="text-sm text-gray-600 mt-1">{{ $exam_date ?? 'Belum Terjadwal' }}</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Pengumuman --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Pengumuman Terbaru</h3>
                    <div class="space-y-4">
                        @forelse($announcements ?? [] as $announcement)
                            <div class="border-l-4 border-blue-600 pl-4 py-2">
                                <h4 class="font-semibold text-gray-900">{{ $announcement->title }}</h4>
                                <p class="text-sm text-gray-600 mt-1">{{ Str::limit($announcement->content, 150) }}</p>
                                <span
                                    class="text-xs text-gray-500 mt-2 block">{{ $announcement->created_at->diffForHumans() }}</span>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">Belum ada pengumuman</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Status Dokumen & Pembayaran --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Dokumen</h3>
                        <div class="space-y-3">
                            @foreach ($document_status ?? [['name' => 'KK & Ijazah', 'status' => 'verified'], ['name' => 'Pas Foto', 'status' => 'pending'], ['name' => 'Bukti Bayar', 'status' => 'unverified']] as $doc)
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">{{ $doc['name'] }}</span>
                                    @php
                                        $s = $doc['status'];
                                        $badges = ['verified' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Verified'], 'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'label' => 'Pending'], 'unverified' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'label' => 'Unverified']];
                                        $b = $badges[$s] ?? $badges['unverified'];
                                    @endphp
                                    <span
                                        class="inline-flex px-2 py-1 rounded text-xs font-medium {{ $b['bg'] }} {{ $b['text'] }}">{{ $b['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Pembayaran</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Biaya Pendaftaran</span>
                                <span class="text-sm font-semibold text-gray-900">Rp
                                    {{ number_format($payment_amount ?? 300000, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Status</span>
                                @php
                                    $s = $payment_status ?? 'pending';
                                    $badges = ['verified' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Lunas'], 'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'label' => 'Pending'], 'unpaid' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' => 'Belum Bayar']];
                                    $b = $badges[$s] ?? $badges['pending'];
                                @endphp
                                <span
                                    class="inline-flex px-2 py-1 rounded text-xs font-medium {{ $b['bg'] }} {{ $b['text'] }}">{{ $b['label'] }}</span>
                            </div>
                            <a href="{{ route('student.payments.index') }}"
                                class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition mt-4">Bayar
                                Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>
