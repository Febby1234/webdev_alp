{{-- resources/views/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDB {{ date('Y') }} - Penerimaan Peserta Didik Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    {{-- Navigation --}}
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <span class="ml-2 text-xl font-bold text-gray-900">PPDB {{ date('Y') }}</span>
                    </div>
                </div>
                <div class="hidden md:flex md:items-center md:space-x-8">
                    <a href="{{ url('/') }}" class="text-gray-900 font-semibold hover:text-blue-600 transition">Beranda</a>
                    <a href="{{ route('public.majors') }}" class="text-gray-600 hover:text-blue-600 transition">Jurusan</a>
                    <a href="{{ route('public.requirements') }}" class="text-gray-600 hover:text-blue-600 transition">Persyaratan</a>
                    <a href="{{ route('public.schedules') }}" class="text-gray-600 hover:text-blue-600 transition">Jadwal</a>
                    <a href="{{ route('public.announcements') }}" class="text-gray-600 hover:text-blue-600 transition">Pengumuman</a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('student.dashboard') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 transition">Masuk</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="bg-gradient-to-br from-blue-600 to-blue-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-5xl font-bold mb-6 leading-tight">
                        Wujudkan Masa Depan Cerahmu Bersama Kami
                    </h1>
                    <p class="text-xl text-blue-100 mb-8">
                        Bergabunglah dengan ribuan siswa yang telah meraih impian mereka. Pendaftaran PPDB {{ date('Y') }} sudah dibuka!
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-blue-600 rounded-lg font-semibold hover:bg-blue-50 transition shadow-lg">
                            Daftar Sekarang
                        </a>
                        <a href="{{ route('public.requirements') }}" class="px-8 py-4 bg-blue-700 text-white rounded-lg font-semibold hover:bg-blue-600 transition">
                            Lihat Persyaratan
                        </a>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20">
                        <h3 class="text-2xl font-bold mb-6">Info Pendaftaran</h3>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 mr-3 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Pendaftaran 100% Online</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 mr-3 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Gratis Biaya Pendaftaran</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 mr-3 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Pengumuman Transparan</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 mr-3 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Akses 24/7</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Stats Section --}}
    <section class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-4xl font-bold text-blue-600">{{ $stats['total_students'] ?? '1000+' }}</div>
                    <div class="text-gray-600 mt-2">Siswa Aktif</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-blue-600">{{ $stats['total_majors'] ?? '5' }}</div>
                    <div class="text-gray-600 mt-2">Program Studi</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-blue-600">95%</div>
                    <div class="text-gray-600 mt-2">Tingkat Kelulusan</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-blue-600">A</div>
                    <div class="text-gray-600 mt-2">Akreditasi</div>
                </div>
            </div>
        </div>
    </section>

    {{-- Majors Section --}}
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Program Studi Tersedia</h2>
                <p class="text-xl text-gray-600">Pilih jurusan yang sesuai dengan minat dan bakatmu</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                @forelse($majors ?? [] as $major)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-6 text-white">
                        <h3 class="text-2xl font-bold">{{ $major->name }}</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">{{ Str::limit($major->description ?? 'Program unggulan dengan fasilitas lengkap dan tenaga pengajar profesional.', 100) }}</p>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm text-gray-500">Kuota Tersedia</span>
                            <span class="text-lg font-bold text-blue-600">{{ $major->quota - ($major->registrations_count ?? 0) }}/{{ $major->quota }}</span>
                        </div>
                        <a href="{{ route('public.majors') }}" class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Lihat Detail
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-12 text-gray-500">
                    Informasi jurusan akan segera tersedia
                </div>
                @endforelse
            </div>
            <div class="text-center mt-12">
                <a href="{{ route('public.majors') }}" class="inline-block px-8 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                    Lihat Semua Jurusan
                </a>
            </div>
        </div>
    </section>

    {{-- Announcements Section --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Pengumuman Terbaru</h2>
                <p class="text-xl text-gray-600">Informasi penting seputar PPDB {{ date('Y') }}</p>
            </div>
            <div class="grid md:grid-cols-2 gap-8">
                @forelse($announcements ?? [] as $announcement)
                <div class="bg-gray-50 rounded-xl p-6 hover:bg-gray-100 transition">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $announcement->title }}</h3>
                            <p class="text-gray-600 text-sm mb-3">{{ Str::limit($announcement->content, 150) }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-500">{{ $announcement->created_at->diffForHumans() }}</span>
                                <a href="{{ route('public.announcements') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Baca Selengkapnya →</a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-2 text-center py-12 text-gray-500">
                    Belum ada pengumuman
                </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="bg-gradient-to-r from-blue-600 to-blue-800 py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <h2 class="text-4xl font-bold mb-6">Siap Bergabung?</h2>
            <p class="text-xl mb-8 text-blue-100">Daftarkan dirimu sekarang dan raih masa depan yang lebih cerah!</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-blue-600 rounded-lg font-semibold hover:bg-blue-50 transition shadow-lg">
                    Daftar Sekarang
                </a>
                <a href="#" class="px-8 py-4 bg-blue-700 text-white rounded-lg font-semibold hover:bg-blue-600 transition border-2 border-white">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-300 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="col-span-2">
                    <div class="flex items-center mb-4">
                        <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <span class="ml-2 text-xl font-bold text-white">PPDB {{ date('Y') }}</span>
                    </div>
                    <p class="text-gray-400 mb-4">
                        Sistem Penerimaan Peserta Didik Baru online yang mudah, cepat, dan transparan.
                    </p>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-4">Menu</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('public.majors') }}" class="hover:text-white transition">Jurusan</a></li>
                        <li><a href="{{ route('public.requirements') }}" class="hover:text-white transition">Persyaratan</a></li>
                        <li><a href="{{ route('public.schedules') }}" class="hover:text-white transition">Jadwal</a></li>
                        <li><a href="{{ route('public.announcements') }}" class="hover:text-white transition">Pengumuman</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-4">Kontak</h3>
                    <ul class="space-y-2 text-sm">
                        <li>Email: info@ppdb.sch.id</li>
                        <li>Telp: (021) 123-4567</li>
                        <li>WhatsApp: 0812-3456-7890</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm text-gray-400">
                <p>&copy; {{ date('Y') }} PPDB. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
