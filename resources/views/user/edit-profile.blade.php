@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded shadow-md p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Edit Profil</h2>
                </div>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('user.update-profile') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Nama Lengkap <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama', auth()->user()->nama) }}"
                            class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-500"
                            required>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">NIP</label>
                        <input type="text" name="nip" value="{{ old('nip', auth()->user()->nip) }}"
                            class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="Masukkan NIP (opsional)">
                    </div>

                    <hr class="my-6 border-gray-300">

                    <h3 class="text-xl font-semibold mb-2 text-gray-800">Ubah Password</h3>
                    <p class="text-sm text-gray-600 mb-4">Kosongkan jika tidak ingin mengubah password <span
                            class="text-red-500">*</span></label></p>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Password Baru</label>
                        <input type="password" name="password"
                            class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="Minimal 6 karakter">
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation"
                            class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="Ulangi password baru">
                    </div>

                    <div class="flex gap-4">
                        <a href="{{ route('dashboard') }}"
                            class="flex-1 bg-white text-green-700 border border-green-700 py-2 px-4 rounded hover:bg-green-100 transition text-center">
                            Batal
                        </a>
                        <button type="submit"
                            class="flex-1 bg-green-700 text-white py-2 px-4 rounded hover:bg-green-800 transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
