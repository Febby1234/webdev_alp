<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PPDB ' . date('Y'))</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    {{-- Navigation --}}
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center">
                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <span class="ml-2 text-xl font-bold text-gray-900">PPDB {{ date('Y') }}</span>
                    </a>
                </div>
                <div class="hidden md:flex md:items-center md:space-x-8">
                    <a href="{{ url('/') }}" class="text-gray-600 hover:text-blue-600 transition">Beranda</a>
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

    {{-- Content --}}
    @yield('content')

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
                    <p class="text-gray-400">
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
