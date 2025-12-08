<x-main-layout>
    <x-slot name="title">Dashboard Mahasiswa</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Mahasiswa</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Progress Bar --}}
            <x-card class="mb-6">
                <h3 class="text-lg font-semibold mb-4">Progress Pendaftaran</h3>
                <div class="flex items-center justify-between">
                    @for($i = 1; $i <= 5; $i++)
                    @if($i > 1)<div class="flex-1 h-1 {{ ($registration_step ?? 1) >= $i ? 'bg-blue-600' : 'bg-gray-300' }}"></div>@endif
                    <div class="flex flex-col items-center flex-1">
                        <div class="w-10 h-10 rounded-full {{ ($registration_step ?? 1) >= $i ? 'bg-blue-600' : 'bg-gray-300' }} flex items-center justify-center text-white font-bold">{{ $i }}</div>
                        <span class="text-xs sm:text-sm mt-2 text-center">{{ ['','Biodata','Orang Tua','Sekolah','Dokumen','Bayar'][$i] }}</span>
                    </div>
                    @endfor
                </div>
            </x-card>

            {{-- Quick Actions --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <x-card-link
                    href="{{ route('student.registration.show') }}"
                    icon="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                    title="Status Pendaftaran"
                    badge="{{ $registration_status ?? 'pending' }}" />

                <x-card-link
                    href="{{ route('student.documents.index') }}"
                    icon="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
                    title="Upload Dokumen"
                    subtitle="{{ $documents_uploaded ?? 0 }} / {{ $total_documents ?? 5 }} Dokumen" />

                <x-card-link
                    href="{{ route('student.exams.schedule') }}"
                    icon="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                    title="Jadwal Ujian"
                    subtitle="{{ $exam_date ?? 'Belum Terjadwal' }}" />
            </div>

            {{-- Pengumuman --}}
            <x-card title="Pengumuman Terbaru" class="mb-6">
                <div class="space-y-4">
                    @forelse($announcements ?? [] as $announcement)
                    <div class="border-l-4 border-blue-600 pl-4 py-2">
                        <h4 class="font-semibold text-gray-900">{{ $announcement->title }}</h4>
                        <p class="text-sm text-gray-600 mt-1">{{ Str::limit($announcement->content, 150) }}</p>
                        <span class="text-xs text-gray-500 mt-2 block">{{ $announcement->created_at->diffForHumans() }}</span>
                    </div>
                    @empty
                    <p class="text-gray-500 text-center py-4">Belum ada pengumuman</p>
                    @endforelse
                </div>
            </x-card>

            {{-- Status Dokumen & Pembayaran --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-card title="Status Dokumen">
                    <div class="space-y-3">
                        @foreach(['KK & Ijazah' => 'verified', 'Pas Foto' => 'pending', 'Bukti Bayar' => 'unverified'] as $doc => $status)
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">{{ $doc }}</span>
                            <x-status-badge :status="$status" />
                        </div>
                        @endforeach
                    </div>
                </x-card>

                <x-card title="Status Pembayaran">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Biaya Pendaftaran</span>
                            <span class="text-sm font-semibold text-gray-900">Rp 300.000</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Status</span>
                            <x-status-badge status="pending" />
                        </div>
                        <a href="{{ route('student.payments.index') }}" class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition mt-4">
                            Bayar Sekarang
                        </a>
                    </div>
                </x-card>
            </div>

        </div>
    </div>
</x-main-layout>
