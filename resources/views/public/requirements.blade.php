@extends('layouts.public')

@section('title', 'Persyaratan Pendaftaran - PPDB ' . date('Y'))

@section('content')
<div class="bg-gradient-to-br from-purple-600 to-purple-800 py-16 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-4">Persyaratan Pendaftaran</h1>
        <p class="text-xl text-purple-100">Pastikan semua dokumen dan syarat terpenuhi sebelum mendaftar</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    {{-- Timeline --}}
    <div class="mb-16">
        <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Tahapan Pendaftaran</h2>
        <div class="grid md:grid-cols-5 gap-4">
            <div class="text-center">
                <div class="w-16 h-16 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-4">
                    <span class="text-2xl font-bold text-blue-600">1</span>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Registrasi Online</h3>
                <p class="text-sm text-gray-600">Buat akun dan isi formulir pendaftaran</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-4">
                    <span class="text-2xl font-bold text-green-600">2</span>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Upload Dokumen</h3>
                <p class="text-sm text-gray-600">Upload semua dokumen yang diperlukan</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 mx-auto bg-yellow-100 rounded-full flex items-center justify-center mb-4">
                    <span class="text-2xl font-bold text-yellow-600">3</span>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Verifikasi</h3>
                <p class="text-sm text-gray-600">Admin memverifikasi data dan dokumen</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 mx-auto bg-purple-100 rounded-full flex items-center justify-center mb-4">
                    <span class="text-2xl font-bold text-purple-600">4</span>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Ujian Seleksi</h3>
                <p class="text-sm text-gray-600">Mengikuti ujian tertulis dan wawancara</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 mx-auto bg-red-100 rounded-full flex items-center justify-center mb-4">
                    <span class="text-2xl font-bold text-red-600">5</span>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Pengumuman</h3>
                <p class="text-sm text-gray-600">Lihat hasil seleksi secara online</p>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-8 mb-16">
        {{-- Syarat Umum --}}
        <div class="bg-white rounded-xl shadow-lg p-8">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 ml-4">Syarat Umum</h2>
            </div>
            <ul class="space-y-4">
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span class="ml-3 text-gray-700">Lulusan SMP/MTs atau sederajat</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span class="ml-3 text-gray-700">Usia maksimal 21 tahun pada {{ date('Y') }}</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span class="ml-3 text-gray-700">Berbadan sehat dan tidak buta warna (untuk jurusan tertentu)</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span class="ml-3 text-gray-700">Berkelakuan baik (tidak terlibat narkoba/kriminal)</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span class="ml-3 text-gray-700">Mampu membaca dan menulis Al-Qur'an dengan baik</span>
                </li>
            </ul>
        </div>

        {{-- Dokumen yang Diperlukan --}}
        <div class="bg-white rounded-xl shadow-lg p-8">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 ml-4">Dokumen yang Diperlukan</h2>
            </div>
            <ul class="space-y-4">
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-purple-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <div class="ml-3">
                        <span class="text-gray-700 font-medium">Ijazah/SKHUN SMP/MTs</span>
                        <p class="text-sm text-gray-500">Format: PDF/JPG, Max: 2MB</p>
                    </div>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-purple-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <div class="ml-3">
                        <span class="text-gray-700 font-medium">Kartu Keluarga (KK)</span>
                        <p class="text-sm text-gray-500">Format: PDF/JPG, Max: 2MB</p>
                    </div>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-purple-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <div class="ml-3">
                        <span class="text-gray-700 font-medium">Akta Kelahiran</span>
                        <p class="text-sm text-gray-500">Format: PDF/JPG, Max: 2MB</p>
                    </div>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-purple-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <div class="ml-3">
                        <span class="text-gray-700 font-medium">Pas Foto 3x4</span>
                        <p class="text-sm text-gray-500">Background merah, Format: JPG, Max: 500KB</p>
                    </div>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-purple-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <div class="ml-3">
                        <span class="text-gray-700 font-medium">Surat Keterangan Sehat</span>
                        <p class="text-sm text-gray-500">Dari dokter/Puskesmas, Format: PDF, Max: 2MB</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    {{-- Biaya Pendaftaran --}}
    <div class="bg-gradient-to-br from-green-50 to-blue-50 rounded-xl p-8 mb-16">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Biaya Pendaftaran</h2>
                <p class="text-gray-600">Investasi untuk masa depan yang lebih cerah</p>
            </div>
            <div class="text-right">
                <div class="text-4xl font-bold text-green-600">GRATIS</div>
                <p class="text-sm text-gray-600">Tidak ada biaya pendaftaran</p>
            </div>
        </div>
        <div class="mt-6 grid md:grid-cols-3 gap-4">
            <div class="bg-white rounded-lg p-4">
                <div class="text-2xl font-bold text-gray-900 mb-1">Rp 0</div>
                <div class="text-sm text-gray-600">Biaya Formulir</div>
            </div>
            <div class="bg-white rounded-lg p-4">
                <div class="text-2xl font-bold text-gray-900 mb-1">Rp 0</div>
                <div class="text-sm text-gray-600">Biaya Ujian</div>
            </div>
            <div class="bg-white rounded-lg p-4">
                <div class="text-2xl font-bold text-gray-900 mb-1">Rp 0</div>
                <div class="text-sm text-gray-600">Biaya Administrasi</div>
            </div>
        </div>
    </div>

    {{-- Jadwal Pendaftaran --}}
    <div class="bg-white rounded-xl shadow-lg p-8 mb-16">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Jadwal Penting</h2>
        <div class="space-y-4">
            <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                <div class="w-24 h-24 bg-blue-100 rounded-lg flex flex-col items-center justify-center flex-shrink-0">
                    <div class="text-2xl font-bold text-blue-600">01</div>
                    <div class="text-xs text-blue-600">Jan {{ date('Y') }}</div>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="font-semibold text-gray-900">Pembukaan Pendaftaran Gelombang 1</h3>
                    <p class="text-sm text-gray-600">Pendaftaran dibuka untuk gelombang pertama</p>
                </div>
                <div class="text-right">
                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-medium">Berlangsung</span>
                </div>
            </div>
            <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                <div class="w-24 h-24 bg-purple-100 rounded-lg flex flex-col items-center justify-center flex-shrink-0">
                    <div class="text-2xl font-bold text-purple-600">15</div>
                    <div class="text-xs text-purple-600">Feb {{ date('Y') }}</div>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="font-semibold text-gray-900">Penutupan Gelombang 1</h3>
                    <p class="text-sm text-gray-600">Batas akhir pendaftaran gelombang pertama</p>
                </div>
                <div class="text-right">
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm font-medium">Akan Datang</span>
                </div>
            </div>
            <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                <div class="w-24 h-24 bg-orange-100 rounded-lg flex flex-col items-center justify-center flex-shrink-0">
                    <div class="text-2xl font-bold text-orange-600">20</div>
                    <div class="text-xs text-orange-600">Feb {{ date('Y') }}</div>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="font-semibold text-gray-900">Ujian Seleksi</h3>
                    <p class="text-sm text-gray-600">Pelaksanaan ujian tertulis dan wawancara</p>
                </div>
                <div class="text-right">
                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm font-medium">Akan Datang</span>
                </div>
            </div>
        </div>
    </div>

    {{-- FAQ --}}
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Pertanyaan yang Sering Diajukan (FAQ)</h2>
        <div class="space-y-4">
            <details class="group border-b border-gray-200 pb-4">
                <summary class="flex justify-between items-center cursor-pointer list-none font-semibold text-gray-900 hover:text-blue-600">
                    <span>Apakah bisa mendaftar lebih dari 1 jurusan?</span>
                    <svg class="w-5 h-5 transition group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </summary>
                <p class="mt-3 text-gray-600">Tidak bisa. Setiap pendaftar hanya dapat memilih 1 (satu) jurusan. Pastikan memilih jurusan yang sesuai dengan minat dan kemampuan Anda.</p>
            </details>
            <details class="group border-b border-gray-200 pb-4">
                <summary class="flex justify-between items-center cursor-pointer list-none font-semibold text-gray-900 hover:text-blue-600">
                    <span>Bagaimana jika dokumen belum lengkap?</span>
                    <svg class="w-5 h-5 transition group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </summary>
                <p class="mt-3 text-gray-600">Anda tetap bisa mendaftar, namun pastikan melengkapi dokumen sebelum batas waktu yang ditentukan agar pendaftaran dapat diproses.</p>
            </details>
            <details class="group border-b border-gray-200 pb-4">
                <summary class="flex justify-between items-center cursor-pointer list-none font-semibold text-gray-900 hover:text-blue-600">
                    <span>Apakah ada tes fisik?</span>
                    <svg class="w-5 h-5 transition group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </summary>
                <p class="mt-3 text-gray-600">Tidak ada tes fisik. Seleksi hanya berupa ujian tertulis dan wawancara.</p>
            </details>
            <details class="group border-b border-gray-200 pb-4">
                <summary class="flex justify-between items-center cursor-pointer list-none font-semibold text-gray-900 hover:text-blue-600">
                    <span>Kapan pengumuman hasil seleksi?</span>
                    <svg class="w-5 h-5 transition group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </summary>
                <p class="mt-3 text-gray-600">Pengumuman akan diumumkan secara online 7 hari setelah ujian seleksi. Anda akan mendapat notifikasi via email.</p>
            </details>
        </div>
    </div>

    {{-- CTA --}}
    <div class="mt-16 text-center">
        <h3 class="text-2xl font-bold text-gray-900 mb-4">Siap Mendaftar?</h3>
        <p class="text-gray-600 mb-8">Pastikan semua persyaratan terpenuhi dan mulai pendaftaran Anda sekarang!</p>
        <a href="{{ route('register') }}" class="inline-block px-8 py-4 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition shadow-lg">
            Daftar Sekarang
        </a>
    </div>
</div>
@endsection
