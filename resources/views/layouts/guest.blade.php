<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    {{-- Public Navigation --}}
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <a href="/" class="flex items-center">
                            <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                            <span class="ml-3 text-xl font-bold text-gray-900">PMB 2025</span>
                        </a>
                    </div>

                    <!-- Public Links -->
                    <div class="hidden sm:ml-10 sm:flex sm:space-x-8">
                        <a href="{{ route('home') }}"
                            class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-900 border-b-2 {{ request()->routeIs('landing') ? 'border-blue-600' : 'border-transparent hover:border-gray-300' }}">
                            Beranda
                        </a>
                        <a href="{{ route('public.majors') }}"
                            class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-900 hover:border-gray-300">
                            Jurusan
                        </a>
                        <a href="{{ route('public.announcements') }}"
                            class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-900 hover:border-gray-300">
                            Pengumuman
                        </a>
                        <a href="{{ route('public.requirements') }}"
                            class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-900 hover:border-gray-300">
                            Persyaratan
                        </a>
                        <a href="{{ route('public.schedules') }}"
                            class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 border-b-2 border-transparent hover:text-gray-900 hover:border-gray-300">
                            Jadwal
                        </a>
                    </div>
                </div>

                <!-- Auth Links -->
                <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
                    @auth
                        @if (auth()->user()->role === 'student')
                            <a href="{{ route('student.dashboard') }}"
                                class="text-sm text-gray-700 hover:text-gray-900">Dashboard</a>
                        @elseif(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}"
                                class="text-sm text-gray-700 hover:text-gray-900">Dashboard Admin</a>
                        @elseif(auth()->user()->role === 'interviewer')
                            <a href="{{ route('interviewer.dashboard') }}"
                                class="text-sm text-gray-700 hover:text-gray-900">Dashboard Interviewer</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-gray-900 mr-4">Masuk</a>
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition shadow-sm">
                            Daftar Sekarang
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <div class="min-h-screen bg-gray-50">
        {{ $slot }}
    </div>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-bold mb-4">PMB 2025</h3>
                    <p class="text-gray-400 text-sm">Universitas Lorem - Penerimaan Mahasiswa Baru</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Menu</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('home') }}" class="hover:text-white">Beranda</a></li>
                        <li><a href="{{ route('public.majors') }}" class="hover:text-white">Jurusan</a></li>
                        <li><a href="{{ route('public.announcements') }}" class="hover:text-white">Pengumuman</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li>📞 0812-3456-7890</li>
                        <li>📧 pmb@universitaslorem.ac.id</li>
                        <li>📍 Jl. Kampus No. 123, Surabaya</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Media Sosial</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white">Instagram</a></li>
                        <li><a href="#" class="hover:text-white">Facebook</a></li>
                        <li><a href="#" class="hover:text-white">Twitter</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm text-gray-400">
                <p>&copy; {{ date('Y') }} Universitas Lorem. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>

</html>
