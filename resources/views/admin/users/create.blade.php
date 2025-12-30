<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah User Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            {{-- Back Button --}}
            <div class="mb-6">
                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Daftar User
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf

                        <div class="space-y-6">
                            {{-- Name --}}
                            <div>
                                <x-input-label for="name" :value="__('Nama Lengkap')" />
                                <x-text-input
                                    id="name"
                                    class="block mt-1 w-full"
                                    type="text"
                                    name="name"
                                    :value="old('name')"
                                    required
                                    autofocus
                                    placeholder="Contoh: John Doe" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            {{-- Email --}}
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input
                                    id="email"
                                    class="block mt-1 w-full"
                                    type="email"
                                    name="email"
                                    :value="old('email')"
                                    required
                                    placeholder="contoh@email.com" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                <p class="text-sm text-gray-500 mt-1">Email akan digunakan untuk login</p>
                            </div>

                            {{-- Role --}}
                            <div>
                                <x-input-label for="role" :value="__('Role/Peran')" />
                                <select id="role"
                                        name="role"
                                        class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                                        required>
                                    <option value="">Pilih Role</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="interviewer" {{ old('role') == 'interviewer' ? 'selected' : '' }}>Interviewer</option>
                                    <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                                </select>
                                <x-input-error :messages="$errors->get('role')" class="mt-2" />
                                <p class="text-sm text-gray-500 mt-1">
                                    <strong>Admin:</strong> Full access |
                                    <strong>Interviewer:</strong> Kelola ujian |
                                    <strong>Student:</strong> Pendaftar
                                </p>
                            </div>

                            {{-- Password --}}
                            <div>
                                <x-input-label for="password" :value="__('Password')" />
                                <x-text-input
                                    id="password"
                                    class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required
                                    placeholder="Minimal 8 karakter" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                <p class="text-sm text-gray-500 mt-1">Password default untuk user baru (minimal 8 karakter)</p>
                            </div>

                            {{-- Password Confirmation --}}
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                                <x-text-input
                                    id="password_confirmation"
                                    class="block mt-1 w-full"
                                    type="password"
                                    name="password_confirmation"
                                    required
                                    placeholder="Ketik ulang password" />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>

                            {{-- Info Box --}}
                            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                                <div class="flex">
                                    <svg class="h-5 w-5 text-blue-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div class="ml-3">
                                        <p class="text-sm text-blue-700">
                                            <span class="font-medium">Catatan:</span> User baru akan menerima email berisi kredensial login mereka.
                                            Pastikan email yang dimasukkan valid dan aktif.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Submit Buttons --}}
                            <div class="flex gap-3 pt-4">
                                <x-primary-button>
                                    {{ __('Simpan User') }}
                                </x-primary-button>
                                <x-secondary-button type="button" onclick="window.location='{{ route('admin.users.index') }}'">
                                    {{ __('Batal') }}
                                </x-secondary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>
