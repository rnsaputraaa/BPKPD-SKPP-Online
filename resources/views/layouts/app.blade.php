<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SKPP Online')</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        @media (max-width: 480px) {
            .placeholder-mobile::placeholder {
                font-size: 12px;
            }
        }
    </style>

    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

    <div id="sidebarOverlay" class="fixed inset-0 bg-gray-100 bg-opacity-50 z-30 hidden lg:hidden"
        onclick="toggleSidebar()">
    </div>

    <div class="flex h-screen">
        <aside id="sidebar"
            class="fixed lg:static inset-y-0 left-0 w-64 bg-white text-gray-800 flex flex-col transform -translate-x-full lg:translate-x-0 transition-transform duration-300 z-40 shadow-lg">

            <div
                class="p-6 bg-green-700 text-white border-b border-green-600 flex justify-between items-center lg:block">

                <div class="flex items-center gap-3">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" class="w-10 h-10 object-contain">

                    <div>
                        <h1 class="text-xl font-bold">SKPP Online</h1>
                        <p class="text-sm mt-1">BPKPD PAMEKASAN</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2 bg-white text-green-700">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center px-4 py-3 rounded hover:bg-green-100 transition {{ request()->routeIs('dashboard') ? 'bg-green-100 font-semibold' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('skpp.index') }}"
                    class="flex items-center px-4 py-3 rounded hover:bg-green-100 transition {{ request()->routeIs('skpp.index') ? 'bg-green-100 font-semibold' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Riwayat Pengajuan</span>
                </a>

                <a href="{{ route('skpp.create') }}"
                    class="flex items-center px-4 py-3 rounded hover:bg-green-100 transition {{ request()->routeIs('skpp.create') ? 'bg-green-100 font-semibold' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Buat SKPP Baru</span>
                </a>
            </nav>

            <div class="p-4 bg-gray-100 border-t border-gray-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium">{{ auth()->user()->nama }}</p>
                        <p class="text-xs">{{ auth()->user()->nip }}</p>
                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-green-700 hover:text-green-800">
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


        <main class="flex-1 overflow-y-auto lg:ml-0">
            <button class="lg:hidden m-4 text-3xl text-green-800" onclick="toggleSidebar()">
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

            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>

</body>

</html>
