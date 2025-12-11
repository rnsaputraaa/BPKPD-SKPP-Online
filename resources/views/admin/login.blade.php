<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - SKPP Online</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-700 min-h-screen flex items-center justify-center p-4">
    <div
        class="absolute inset-0 opacity-20 pointer-events-none z-0 bg-[linear-gradient(#ffffff33_1px,transparent_1px),linear-gradient(90deg,#ffffff33_1px,transparent_1px)] bg-size-[50px_50px]">
    </div>

    <div class="bg-white rounded shadow-2xl w-full max-w-md p-8 relative z-10">
        <div class="text-center mb-8">
            <div class="inline-block p-4 bg-gray-100 rounded-full mb-4">
                <svg class="w-12 h-12 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Admin Login</h1>
            <p class="text-gray-600">SKPP Online - BPKPD Pamekasan</p>
        </div>

        <form action="{{ route('admin.login') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}"
                    class="w-full px-4 py-3 border rounded focus:ring-2 focus:ring-gray-500 focus:border-transparent outline-none transition @error('username') border-red-500 @enderror"
                    placeholder="Masukkan username" autocomplete="off" required>
                @error('username')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>

                <div class="relative">
                    <input type="password" id="password" name="password"
                        class="w-full px-4 py-3 pr-12 border rounded focus:ring-2 focus:ring-gray-500 focus:border-transparent outline-none transition @error('password') border-red-500 @enderror"
                        placeholder="Masukkan password" required>

                    <button type="button" onclick="togglePassword2()"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 pl-3 border-l text-gray-600 hover:text-gray-700">
                        <svg id="showIcon2" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>

                        <svg id="hideIcon2" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hidden" fill="none"
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
                class="w-full bg-gray-600 text-white py-3 rounded font-semibold hover:bg-gray-700 transition duration-200">
                Login
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-gray-600 text-sm">Bukan admin?
                <a href="{{ route('login') }}" class="text-green-600 font-semibold hover:underline">Login sebagai
                    User</a>
            </p>
        </div>
    </div>

    <script>
        function togglePassword2() {
            const input = document.getElementById("password");
            const showIcon = document.getElementById("showIcon2");
            const hideIcon = document.getElementById("hideIcon2");

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
