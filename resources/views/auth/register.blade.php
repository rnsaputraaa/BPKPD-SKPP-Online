<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SKPP Online</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>

    @vite('resources/css/app.css')
</head>

<body class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden bg-green-700">

    <div
        class="absolute inset-0 opacity-20 pointer-events-none z-0 
        bg-[linear-gradient(#ffffff33_1px,transparent_1px),linear-gradient(90deg,#ffffff33_1px,transparent_1px)] 
        bg-size-[50px_50px]">
    </div>

    <div class="bg-gray-100 rounded-lg shadow-2xl w-full max-w-md p-8 relative z-10">
        <div class="flex items-center justify-center mb-8 gap-4">
            <img src="img/logo.png" alt="Logo" class="w-14 h-14 object-contain">

            <div class="text-left">
                <h1 class="text-2xl font-bold text-gray-800 mb-1">SKPP Online</h1>
                <p class="text-gray-600">BPKPD PAMEKASAN</p>
            </div>
        </div>


        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama') }}" autocomplete="off"
                    class="w-full px-4 py-3 border rounded focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition @error('nama') border-red-500 @enderror"
                    placeholder="Masukkan nama lengkap" required>
                @error('nama')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="nip" class="block text-sm font-medium text-gray-700 mb-2">NIP</label>
                <input type="text" id="nip" name="nip" value="{{ old('nip') }}" autocomplete="off"
                    class="w-full px-4 py-3 border rounded focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition @error('nip') border-red-500 @enderror"
                    placeholder="Masukkan NIP" required>
                @error('nip')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" id="password" name="password"
                    class="w-full px-4 py-3 border rounded focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition @error('password') border-red-500 @enderror"
                    placeholder="Minimal 6 karakter" required>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi
                    Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="w-full px-4 py-3 border rounded focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition"
                    placeholder="Ulangi password" required>
            </div>

            <button type="submit"
                class="w-full bg-green-600 text-white py-3 rounded font-semibold hover:bg-green-700 transition duration-200">
                Daftar
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-gray-600">Sudah punya akun?
                <a href="{{ route('login') }}" class="text-green-600 font-semibold hover:underline">Login di sini</a>
            </p>
        </div>
    </div>
</body>

</html>
