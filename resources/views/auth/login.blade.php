<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SKPP Online</title>
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
        class="absolute inset-0 opacity-20 bg-[linear-gradient(#ffffff33_1px,transparent_1px),linear-gradient(90deg,#ffffff33_1px,transparent_1px)] bg-size-[50px_50px]">
    </div>

    <div
        class="relative bg-gray-100 rounded-2xl w-full max-w-5xl grid grid-cols-1 md:grid-cols-2 auto-rows-fr border border-white/30 overflow-hidden">

        <div class="hidden md:flex items-center justify-center bg-gray-100 p-6 md:rounded-l-2xl">
            <img src="img/bg.jpg" alt="Background" class="rounded-xl shadow-lg object-cover w-full h-full">
        </div>

        <div class="p-10">
            <div class="flex items-center justify-center mb-8 gap-4">
                <img src="img/logo.png" alt="Logo" class="w-14 h-14 object-contain">

                <div class="text-left">
                    <h1 class="text-2xl font-bold text-gray-800 mb-1">SKPP Online</h1>
                    <p class="text-gray-600">BPKPD PAMEKASAN</p>
                </div>
            </div>

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label for="nip" class="block text-sm font-medium text-gray-700 mb-2">NIP</label>
                    <input type="text" id="nip" name="nip" value="{{ old('nip') }}" autocomplete="off"
                        class="w-full px-4 py-3 border rounded focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition @error('nip') border-red-500 @enderror"
                        placeholder="Masukkan NIP" required>
                    @error('nip')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" id="password" name="password"
                        class="w-full px-4 py-3 border rounded focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition @error('password') border-red-500 @enderror"
                        placeholder="Masukkan password" required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-green-600 text-white py-3 rounded font-semibold hover:bg-green-700 transition duration-200 shadow-md hover:shadow-lg">
                    Login
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-gray-600">Belum punya akun?
                    <a href="{{ route('register') }}" class="text-green-600 font-semibold hover:underline">Daftar di
                        sini</a>
                </p>
            </div>

            <div class="relative my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-500"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="bg-gray-100 px-3 text-sm text-gray-600">atau</span>
                </div>
            </div>

            <a href="{{ route('admin.login') }}"
                class="w-full flex items-center justify-center gap-2 py-3 border border-gray-600 text-gray-700 font-semibold rounded hover:bg-gray-300 transition shadow-sm">
                Admin
            </a>
        </div>
    </div>

</body>

</html>
