<x-guest-layout>
    <div class="min-h-screen flex">
        {{-- Left Side - Branding --}}
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-green-600 to-green-800 p-12 items-center justify-center relative overflow-hidden">
            {{-- Background Pattern --}}
            <div class="absolute inset-0 opacity-10">
                <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                            <circle cx="20" cy="20" r="1" fill="white"/>
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#grid)"/>
                </svg>
            </div>

            <div class="relative z-10 text-white text-center">
                {{-- Logo/Icon --}}
                <div class="mb-8">
                    <div class="w-24 h-24 mx-auto bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </div>
                </div>

                <h1 class="text-4xl font-bold mb-4">Daftar PPDB {{ date('Y') }}</h1>
                <p class="text-xl text-green-100 mb-8">Mulai Perjalanan Pendidikan Anda</p>

                <div class="max-w-md mx-auto">
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20">
                        <h3 class="font-semibold mb-4 text-lg">Langkah Pendaftaran:</h3>
                        <div class="space-y-3 text-left">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-6 h-6 rounded-full bg-white/20 flex items-center justify-center mr-3 mt-0.5">
                                    <span class="text-sm font-bold">1</span>
                                </div>
                                <p class="text-sm text-green-100">Buat akun dengan email aktif</p>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-6 h-6 rounded-full bg-white/20 flex items-center justify-center mr-3 mt-0.5">
                                    <span class="text-sm font-bold">2</span>
                                </div>
                                <p class="text-sm text-green-100">Lengkapi formulir pendaftaran</p>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-6 h-6 rounded-full bg-white/20 flex items-center justify-center mr-3 mt-0.5">
                                    <span class="text-sm font-bold">3</span>
                                </div>
                                <p class="text-sm text-green-100">Upload dokumen yang diperlukan</p>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-6 h-6 rounded-full bg-white/20 flex items-center justify-center mr-3 mt-0.5">
                                    <span class="text-sm font-bold">4</span>
                                </div>
                                <p class="text-sm text-green-100">Tunggu konfirmasi dari admin</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Side - Register Form --}}
        <div class="flex-1 flex items-center justify-center p-8 bg-gray-50">
            <div class="w-full max-w-md">
                {{-- Mobile Logo --}}
                <div class="lg:hidden text-center mb-8">
                    <div class="w-16 h-16 mx-auto bg-green-600 rounded-full flex items-center justify-center mb-3">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">PPDB {{ date('Y') }}</h2>
                </div>

                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">Buat Akun Baru</h2>
                        <p class="text-gray-600">Daftar untuk memulai proses pendaftaran</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="space-y-6">
                        @csrf

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Nama Lengkap')" class="text-gray-700 font-semibold" />
                            <div class="relative mt-2">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <x-text-input id="name"
                                              class="block w-full pl-10 pr-3 py-3 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                              type="text"
                                              name="name"
                                              :value="old('name')"
                                              placeholder="Masukkan nama lengkap sesuai KTP/Kartu Keluarga"
                                              required
                                              autofocus
                                              autocomplete="name" />
                            </div>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email Address -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-semibold" />
                            <div class="relative mt-2">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                    </svg>
                                </div>
                                <x-text-input id="email"
                                              class="block w-full pl-10 pr-3 py-3 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                              type="email"
                                              name="email"
                                              :value="old('email')"
                                              placeholder="nama@email.com"
                                              required
                                              autocomplete="username" />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            <p class="text-xs text-gray-500 mt-1">Gunakan email aktif untuk verifikasi</p>
                        </div>

                        <!-- Password -->
                        <div>
                            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-semibold" />
                            <div class="relative mt-2">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <x-text-input id="password"
                                              class="block w-full pl-10 pr-3 py-3 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                              type="password"
                                              name="password"
                                              placeholder="Minimal 8 karakter"
                                              required
                                              autocomplete="new-password" />
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-gray-700 font-semibold" />
                            <div class="relative mt-2">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                                <x-text-input id="password_confirmation"
                                              class="block w-full pl-10 pr-3 py-3 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                              type="password"
                                              name="password_confirmation"
                                              placeholder="Ketik ulang password"
                                              required
                                              autocomplete="new-password" />
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <!-- Terms Agreement -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <svg class="h-5 w-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="ml-3 text-sm text-blue-800">
                                    Dengan mendaftar, Anda menyetujui <a href="#" class="font-semibold underline">Syarat & Ketentuan</a> serta <a href="#" class="font-semibold underline">Kebijakan Privasi</a> kami.
                                </p>
                            </div>
                        </div>

                        <!-- Register Button -->
                        <div>
                            <button type="submit"
                                    class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                                Daftar Sekarang
                            </button>
                        </div>

                        <!-- Login Link -->
                        <div class="text-center pt-4 border-t border-gray-200">
                            <p class="text-sm text-gray-600">
                                Sudah punya akun?
                                <a href="{{ route('login') }}"
                                   class="font-semibold text-green-600 hover:text-green-800 transition">
                                    Masuk di sini
                                </a>
                            </p>
                        </div>
                    </form>
                </div>

                <!-- Help Text -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-500">
                        Butuh bantuan?
                        <a href="#" class="text-green-600 hover:text-green-800 font-medium">Hubungi Kami</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
