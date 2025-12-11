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

                    <div class="relative">
                        <input type="password" id="password" name="password"
                            class="w-full px-4 py-3 pr-12 border rounded focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition @error('password') border-red-500 @enderror"
                            placeholder="Masukkan password" required>

                        <button type="button" onclick="togglePassword()"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 pl-3 border-l text-gray-600 hover:text-gray-700">
                            <svg id="showIcon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>

                            <svg id="hideIcon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hidden" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.965 9.965 0 012.132-3.568M6.228 6.228A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a10.024 10.024 0 01-4.132 5.568M4.5 4.5l15 15" />
                            </svg>
                        </button>
                    </div>

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

    <script>
        function togglePassword() {
            const input = document.getElementById("password");
            const showIcon = document.getElementById("showIcon");
            const hideIcon = document.getElementById("hideIcon");

            if (input.type === "password") {
                input.type = "text";
                showIcon.classList.add("hidden");
                hideIcon.classList.remove("hidden");
            } else {
                input.type = "password";
                hideIcon.classList.add("hidden");
                showIcon.classList.remove("hidden");
            }
        }
    </script>

</body>

</html>
