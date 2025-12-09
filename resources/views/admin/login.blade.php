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
                    placeholder="Masukkan username" required>
                @error('username')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" id="password" name="password"
                    class="w-full px-4 py-3 border rounded focus:ring-2 focus:ring-gray-500 focus:border-transparent outline-none transition @error('password') border-red-500 @enderror"
                    placeholder="Masukkan password" required>
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
</body>

</html>
