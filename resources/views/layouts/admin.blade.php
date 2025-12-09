<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - SKPP Online')</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

    <div id="sidebarOverlay" class="fixed inset-0 bg-gray-100 bg-opacity-40 z-30 hidden lg:hidden"
        onclick="toggleSidebar()"></div>

    <div class="flex h-screen">
        <aside id="sidebar"
            class="w-64 bg-white flex flex-col shadow-lg transform -translate-x-full lg:translate-x-0 transition-transform duration-300 fixed lg:static inset-y-0 z-40">

            <div class="p-6 bg-gray-700 border-b border-gray-700">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 flex items-center justify-center">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo" class="w-10 h-10 object-contain">
                    </div>
                    <div>
                        <h1 class="text-xl text-white font-bold">Admin Panel</h1>
                        <p class="text-sm text-gray-400">BPKPD Pamekasan</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2 text-gray-700">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-3 rounded hover:bg-gray-300 transition {{ request()->routeIs('admin.dashboard') ? 'bg-gray-300' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.skpp.index') }}"
                    class="flex items-center px-4 py-3 rounded hover:bg-gray-300 transition {{ request()->routeIs('admin.skpp.*') ? 'bg-gray-300' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Kelola Pengajuan</span>
                </a>
            </nav>

            <div class="p-4 bg-gray-100 border-t border-gray-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium">{{ auth()->user()->nama }}</p>
                        <p class="text-xs">{{ auth()->user()->nip }}</p>
                    </div>

                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-gray-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

        </aside>

        <main class="flex-1 overflow-y-auto">

            <button class="lg:hidden m-4 text-3xl text-gray-700" onclick="toggleSidebar()">
                ☰
            </button>

            <div class="p-8">
                @if (session('success'))
                    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                        role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                        role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            const hidden = sidebar.classList.contains('-translate-x-full');

            if (hidden) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }
    </script>

</body>

</html>
