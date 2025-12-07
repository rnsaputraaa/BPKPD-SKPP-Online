@extends('layouts.admin')

@section('title', 'Admin-Dashboard')

@section('content')
    <div class="flex h-screen">

        <main class="flex-1 overflow-y-auto">
            <div class="p-8">
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
                    <p class="text-gray-600 mt-2">Selamat datang di panel administrator</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Total User</p>
                                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalUsers }}</h3>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Total SKPP</p>
                                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalSkpp }}</h3>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Diproses</p>
                                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalDiproses }}</h3>
                            </div>
                            <div class="w-12 h-12 bg-yellow-100 rounded flex items-center justify-center">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Disetujui</p>
                                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalDisetujui }}</h3>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 rounded flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded shadow">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-800">SKPP Terbaru</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No.
                                        Urut</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipe
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama
                                        Pegawai</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($recentSkpp as $skpp)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ str_pad($skpp->nomor_urut, 3, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $skpp->user->nama }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($skpp->tipe == 'pensiun')
                                                <span
                                                    class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Pensiun</span>
                                            @elseif($skpp->tipe == 'meninggal_dunia')
                                                <span
                                                    class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Meninggal
                                                    Dunia</span>
                                            @else
                                                <span
                                                    class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">Mutasi</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $skpp->nama }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($skpp->status == 'pending')
                                                <span
                                                    class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                            @elseif($skpp->status == 'disetujui')
                                                <span
                                                    class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                            @else
                                                <span
                                                    class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $skpp->created_at->format('d/m/Y H:i') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-8 bg-yellow-50 border-l-4 border-yellow-500 p-6 rounded">
                    <div class="flex">
                        <div class="shrink-0">
                            <i class="fas fa-exclamation-triangle text-yellow-500 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Fitur Admin dalam Pengembangan</h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <p>Fitur admin lengkap sedang dalam tahap pengembangan dan akan segera ditambahkan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    </body>

    </html>
@endsection
