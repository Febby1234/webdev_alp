<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
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
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="space-y-6">
                            {{-- Name --}}
                            <div>
                                <x-input-label for="name" :value="__('Nama Lengkap')" />
                                <x-text-input
                                    id="name"
                                    class="block mt-1 w-full"
                                    type="text"
                                    name="name"
                                    :value="old('name', $user->name)"
                                    required
                                    autofocus />
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
                                    :value="old('email', $user->email)"
                                    required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            {{-- Role --}}
                            <div>
                                <x-input-label for="role" :value="__('Role/Peran')" />
                                <select id="role"
                                        name="role"
                                        class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                                        required
                                        {{ $user->id == auth()->id() ? 'disabled' : '' }}>
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="interviewer" {{ old('role', $user->role) == 'interviewer' ? 'selected' : '' }}>Interviewer</option>
                                    <option value="student" {{ old('role', $user->role) == 'student' ? 'selected' : '' }}>Student</option>
                                </select>
                                <x-input-error :messages="$errors->get('role')" class="mt-2" />
                                @if($user->id == auth()->id())
                                <p class="text-sm text-yellow-600 mt-1">⚠️ Anda tidak dapat mengubah role Anda sendiri</p>
                                @endif
                            </div>

                            {{-- User Info --}}
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-900 mb-3">Informasi User</h4>
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-600">Status Email</p>
                                        <p class="font-medium text-gray-900">
                                            @if($user->email_verified_at)
                                                <span class="text-green-600">✓ Verified</span>
                                            @else
                                                <span class="text-yellow-600">⚠ Unverified</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600">Bergabung</p>
                                        <p class="font-medium text-gray-900">{{ $user->created_at->format('d M Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600">Login Terakhir</p>
                                        <p class="font-medium text-gray-900">
                                            {{ $user->last_login_at ? $user->last_login_at->format('d M Y, H:i') : 'Belum pernah login' }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600">Terakhir Diubah</p>
                                        <p class="font-medium text-gray-900">{{ $user->updated_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Submit Buttons --}}
                            <div class="flex gap-3 pt-4">
                                <x-primary-button>
                                    {{ __('Simpan Perubahan') }}
                                </x-primary-button>
                                <x-secondary-button type="button" onclick="window.location='{{ route('admin.users.index') }}'">
                                    {{ __('Batal') }}
                                </x-secondary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Reset Password Section --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 border-l-4 border-yellow-500">
                    <h3 class="text-lg font-semibold text-yellow-600 mb-2">Reset Password</h3>
                    <p class="text-sm text-gray-600 mb-4">
                        Reset password user ini ke password default baru
                    </p>
                    <form action="{{ route('admin.users.resetPassword', $user->id) }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="new_password" :value="__('Password Baru')" />
                                <x-text-input
                                    id="new_password"
                                    class="block mt-1 w-full"
                                    type="password"
                                    name="new_password"
                                    required
                                    placeholder="Minimal 8 karakter" />
                                <x-input-error :messages="$errors->get('new_password')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="new_password_confirmation" :value="__('Konfirmasi Password Baru')" />
                                <x-text-input
                                    id="new_password_confirmation"
                                    class="block mt-1 w-full"
                                    type="password"
                                    name="new_password_confirmation"
                                    required />
                            </div>
                            <button type="submit"
                                    class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition"
                                    onclick="return confirm('Yakin ingin reset password user ini?')">
                                Reset Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Danger Zone --}}
            @if($user->id != auth()->id())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 border-l-4 border-red-500">
                    <h3 class="text-lg font-semibold text-red-600 mb-2">Danger Zone</h3>
                    <p class="text-sm text-gray-600 mb-4">
                        Hapus user ini secara permanen. Tindakan ini tidak dapat dibatalkan.
                    </p>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus user {{ $user->name }}? Semua data terkait akan ikut terhapus.')">
                        @csrf
                        @method('DELETE')
                        <x-danger-button type="submit">
                            {{ __('Hapus User') }}
                        </x-danger-button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-main-layout>
