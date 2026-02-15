@extends('layouts.admin')

@section('title', 'Tambah Pegawai')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Tambah Pegawai Baru</h1>
        <p class="text-gray-600 mt-1">Daftarkan pegawai baru untuk mengakses sistem SKPP</p>
    </div>

    <div class="flex justify-center">
        <div class="w-full max-w-3xl">
            <div class="bg-white rounded shadow-sm border border-gray-300">
                <div class="p-6 border-b border-gray-300">
                    <div class="bg-blue-50 border border-blue-200 rounded p-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div class="text-sm text-blue-700">
                                <p class="font-semibold mb-1">Informasi</p>
                                <p>Pegawai yang didaftarkan akan mendapatkan akses untuk login ke sistem SKPP dengan NIP dan
                                    password yang Anda tentukan.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.pegawai.store') }}" method="POST" id="formPegawai" class="p-6">
                    @csrf
                    <div class="mb-6">
                        <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama" name="nama" value="{{ old('nama') }}"
                            class="w-full px-4 py-2.5 border rounded focus:ring-2 focus:ring-gray-600 focus:border-gray-600 @error('nama') border-red-500 @enderror"
                            placeholder="Masukkan nama lengkap pegawai" required>
                        @error('nama')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="nip" class="block text-sm font-semibold text-gray-700 mb-2">
                            NIP <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nip" name="nip" value="{{ old('nip') }}"
                            class="w-full px-4 py-2.5 border rounded focus:ring-2 focus:ring-gray-600 focus:border-gray-600 @error('nip') border-red-500 @enderror"
                            placeholder="Masukkan NIP pegawai" maxlength="50" required>
                        @error('nip')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" id="password" name="password"
                                class="w-full px-4 py-2.5 pr-12 border rounded focus:ring-2 focus:ring-gray-600 focus:border-gray-600 @error('password') border-red-500 @enderror"
                                placeholder="Masukkan password" minlength="6" required>
                            <button type="button" id="togglePassword"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-3 text-xs text-gray-500">Password minimal 6 karakter</p>
                    </div>

                    <div class="pt-5 flex gap-3">
                        <a href="{{ route('admin.pegawai.index') }}"
                            class="flex-1 px-6 py-2.5 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition text-center">
                            Batal
                        </a>
                        <button type="submit"
                            class="flex-1 px-6 py-2.5 bg-gray-600 text-white rounded hover:bg-gray-700 transition">
                            Tambah Data Pegawai
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
            }
        });

        document.getElementById('formPegawai').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            if (password.length < 6) {
                e.preventDefault();
                alert('Password minimal 6 karakter!');
                document.getElementById('password').focus();
            }
        });
    </script>
@endsection
