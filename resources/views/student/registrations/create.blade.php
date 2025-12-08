<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Pendaftaran PMB') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    {{-- Step Indicator --}}
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">Step {{ $current_step ?? 1 }} of 4</span>
                            <span class="text-sm text-gray-500">{{ $step_title ?? 'Biodata Pribadi' }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: {{ (($current_step ?? 1) / 4) * 100 }}%"></div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('student.registration.store') }}" enctype="multipart/form-data">
                        @csrf

                        {{-- Step 1: Biodata Pribadi --}}
                        <div id="step-1" class="step-content" style="display: {{ ($current_step ?? 1) == 1 ? 'block' : 'none' }}">
                            <h3 class="text-lg font-semibold mb-6 text-gray-900">Biodata Pribadi</h3>

                            <div class="space-y-4">
                                {{-- Nama Lengkap --}}
                                <div>
                                    <x-input-label for="fullname" :value="__('Nama Lengkap')" />
                                    <x-text-input id="fullname" class="block mt-1 w-full" type="text" name="fullname" :value="old('fullname')" required />
                                    <x-input-error :messages="$errors->get('fullname')" class="mt-2" />
                                </div>

                                {{-- Jenis Kelamin --}}
                                <div>
                                    <x-input-label for="gender" :value="__('Jenis Kelamin')" />
                                    <select id="gender" name="gender" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                                </div>

                                {{-- Tempat Lahir --}}
                                <div>
                                    <x-input-label for="place_of_birth" :value="__('Tempat Lahir')" />
                                    <x-text-input id="place_of_birth" class="block mt-1 w-full" type="text" name="place_of_birth" :value="old('place_of_birth')" required />
                                    <x-input-error :messages="$errors->get('place_of_birth')" class="mt-2" />
                                </div>

                                {{-- Tanggal Lahir --}}
                                <div>
                                    <x-input-label for="date_of_birth" :value="__('Tanggal Lahir')" />
                                    <x-text-input id="date_of_birth" class="block mt-1 w-full" type="date" name="date_of_birth" :value="old('date_of_birth')" required />
                                    <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                                </div>

                                {{-- Alamat --}}
                                <div>
                                    <x-input-label for="address" :value="__('Alamat Lengkap')" />
                                    <textarea id="address" name="address" rows="3" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>{{ old('address') }}</textarea>
                                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                                </div>

                                {{-- No. Telepon --}}
                                <div>
                                    <x-input-label for="phone" :value="__('No. Telepon')" />
                                    <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')" required />
                                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        {{-- Step 2: Data Orang Tua --}}
                        <div id="step-2" class="step-content" style="display: {{ ($current_step ?? 1) == 2 ? 'block' : 'none' }}">
                            <h3 class="text-lg font-semibold mb-6 text-gray-900">Data Orang Tua</h3>

                            <div class="space-y-6">
                                {{-- Data Ayah --}}
                                <div class="border-b pb-4">
                                    <h4 class="font-semibold text-gray-800 mb-4">Data Ayah</h4>
                                    <div class="space-y-4">
                                        <div>
                                            <x-input-label for="father_name" :value="__('Nama Ayah')" />
                                            <x-text-input id="father_name" class="block mt-1 w-full" type="text" name="father_name" :value="old('father_name')" required />
                                            <x-input-error :messages="$errors->get('father_name')" class="mt-2" />
                                        </div>

                                        <div>
                                            <x-input-label for="father_job" :value="__('Pekerjaan Ayah')" />
                                            <x-text-input id="father_job" class="block mt-1 w-full" type="text" name="father_job" :value="old('father_job')" />
                                            <x-input-error :messages="$errors->get('father_job')" class="mt-2" />
                                        </div>

                                        <div>
                                            <x-input-label for="father_phone" :value="__('No. Telepon Ayah')" />
                                            <x-text-input id="father_phone" class="block mt-1 w-full" type="tel" name="father_phone" :value="old('father_phone')" />
                                            <x-input-error :messages="$errors->get('father_phone')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>

                                {{-- Data Ibu --}}
                                <div>
                                    <h4 class="font-semibold text-gray-800 mb-4">Data Ibu</h4>
                                    <div class="space-y-4">
                                        <div>
                                            <x-input-label for="mother_name" :value="__('Nama Ibu')" />
                                            <x-text-input id="mother_name" class="block mt-1 w-full" type="text" name="mother_name" :value="old('mother_name')" required />
                                            <x-input-error :messages="$errors->get('mother_name')" class="mt-2" />
                                        </div>

                                        <div>
                                            <x-input-label for="mother_job" :value="__('Pekerjaan Ibu')" />
                                            <x-text-input id="mother_job" class="block mt-1 w-full" type="text" name="mother_job" :value="old('mother_job')" />
                                            <x-input-error :messages="$errors->get('mother_job')" class="mt-2" />
                                        </div>

                                        <div>
                                            <x-input-label for="mother_phone" :value="__('No. Telepon Ibu')" />
                                            <x-text-input id="mother_phone" class="block mt-1 w-full" type="tel" name="mother_phone" :value="old('mother_phone')" />
                                            <x-input-error :messages="$errors->get('mother_phone')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Step 3: Asal Sekolah --}}
                        <div id="step-3" class="step-content" style="display: {{ ($current_step ?? 1) == 3 ? 'block' : 'none' }}">
                            <h3 class="text-lg font-semibold mb-6 text-gray-900">Asal Sekolah</h3>

                            <div class="space-y-4">
                                <div>
                                    <x-input-label for="school_name" :value="__('Nama Sekolah')" />
                                    <x-text-input id="school_name" class="block mt-1 w-full" type="text" name="school_name" :value="old('school_name')" required />
                                    <x-input-error :messages="$errors->get('school_name')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="graduation_year" :value="__('Tahun Lulus')" />
                                    <x-text-input id="graduation_year" class="block mt-1 w-full" type="number" name="graduation_year" :value="old('graduation_year')" required min="2000" max="2030" />
                                    <x-input-error :messages="$errors->get('graduation_year')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="average_grade" :value="__('Rata-rata Nilai Rapor')" />
                                    <x-text-input id="average_grade" class="block mt-1 w-full" type="number" name="average_grade" :value="old('average_grade')" step="0.01" min="0" max="100" />
                                    <x-input-error :messages="$errors->get('average_grade')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="major_id" :value="__('Jurusan yang Dipilih')" />
                                    <select id="major_id" name="major_id" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
                                        <option value="">Pilih Jurusan</option>
                                        @foreach($majors ?? [] as $major)
                                        <option value="{{ $major->id }}" {{ old('major_id') == $major->id ? 'selected' : '' }}>
                                            {{ $major->name }} (Kuota: {{ $major->quota }})
                                        </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('major_id')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        {{-- Step 4: Preview --}}
                        <div id="step-4" class="step-content" style="display: {{ ($current_step ?? 1) == 4 ? 'block' : 'none' }}">
                            <h3 class="text-lg font-semibold mb-6 text-gray-900">Preview Data</h3>

                            <div class="bg-gray-50 rounded-lg p-6 space-y-4">
                                <div class="border-b pb-4">
                                    <h4 class="font-semibold text-gray-800 mb-3">Biodata Pribadi</h4>
                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <span class="text-gray-600">Nama:</span>
                                            <span class="font-medium ml-2" id="preview-fullname">-</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Jenis Kelamin:</span>
                                            <span class="font-medium ml-2" id="preview-gender">-</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Tempat/Tanggal Lahir:</span>
                                            <span class="font-medium ml-2" id="preview-birth">-</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">No. Telepon:</span>
                                            <span class="font-medium ml-2" id="preview-phone">-</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-b pb-4">
                                    <h4 class="font-semibold text-gray-800 mb-3">Data Orang Tua</h4>
                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <span class="text-gray-600">Nama Ayah:</span>
                                            <span class="font-medium ml-2" id="preview-father">-</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Nama Ibu:</span>
                                            <span class="font-medium ml-2" id="preview-mother">-</span>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="font-semibold text-gray-800 mb-3">Asal Sekolah</h4>
                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <span class="text-gray-600">Nama Sekolah:</span>
                                            <span class="font-medium ml-2" id="preview-school">-</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Tahun Lulus:</span>
                                            <span class="font-medium ml-2" id="preview-year">-</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Jurusan Dipilih:</span>
                                            <span class="font-medium ml-2" id="preview-major">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 p-4 bg-yellow-50 border-l-4 border-yellow-400">
                                <p class="text-sm text-yellow-700">
                                    <strong>Perhatian:</strong> Pastikan semua data yang Anda masukkan sudah benar.
                                    Data yang sudah disubmit tidak dapat diubah kecuali dengan menghubungi admin.
                                </p>
                            </div>
                        </div>

                        {{-- Navigation Buttons --}}
                        <div class="flex justify-between mt-8">
                            <button type="button" id="btn-prev" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition" style="display: none;">
                                ← Sebelumnya
                            </button>

                            <div class="ml-auto flex gap-3">
                                <button type="button" id="btn-next" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                    Selanjutnya →
                                </button>
                                <button type="submit" id="btn-submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition" style="display: none;">
                                    Submit Pendaftaran
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let currentStep = 1;
        const totalSteps = 4;

        function showStep(step) {
            // Hide all steps
            document.querySelectorAll('.step-content').forEach(el => {
                el.style.display = 'none';
            });

            // Show current step
            document.getElementById(`step-${step}`).style.display = 'block';

            // Update button visibility
            document.getElementById('btn-prev').style.display = step > 1 ? 'block' : 'none';
            document.getElementById('btn-next').style.display = step < totalSteps ? 'block' : 'none';
            document.getElementById('btn-submit').style.display = step === totalSteps ? 'block' : 'none';

            // Update preview if on step 4
            if (step === 4) {
                updatePreview();
            }
        }

        function updatePreview() {
            document.getElementById('preview-fullname').textContent = document.getElementById('fullname').value || '-';
            document.getElementById('preview-gender').textContent = document.getElementById('gender').value === 'L' ? 'Laki-laki' : 'Perempuan';
            document.getElementById('preview-birth').textContent = `${document.getElementById('place_of_birth').value}, ${document.getElementById('date_of_birth').value}`;
            document.getElementById('preview-phone').textContent = document.getElementById('phone').value || '-';
            document.getElementById('preview-father').textContent = document.getElementById('father_name').value || '-';
            document.getElementById('preview-mother').textContent = document.getElementById('mother_name').value || '-';
            document.getElementById('preview-school').textContent = document.getElementById('school_name').value || '-';
            document.getElementById('preview-year').textContent = document.getElementById('graduation_year').value || '-';
            document.getElementById('preview-major').textContent = document.getElementById('major_id').options[document.getElementById('major_id').selectedIndex]?.text || '-';
        }

        document.getElementById('btn-next').addEventListener('click', () => {
            if (currentStep < totalSteps) {
                currentStep++;
                showStep(currentStep);
            }
        });

        document.getElementById('btn-prev').addEventListener('click', () => {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        });

        // Initialize
        showStep(currentStep);
    </script>
    @endpush
</x-main-layout>
