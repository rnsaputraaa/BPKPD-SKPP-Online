@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
        <p class="text-gray-600 mt-1">Selamat datang, {{ auth()->user()->nama }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total User</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $totalUsers }}</h3>
                    <p class="text-xs text-gray-500 mt-1">Pengguna terdaftar</p>
                </div>
                <div
                    class="w-14 h-14 bg-linear-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total SKPP</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $totalSkpp }}</h3>
                    <p class="text-xs text-gray-500 mt-1">Semua pengajuan</p>
                </div>
                <div
                    class="w-14 h-14 bg-linear-to-br from-gray-500 to-gray-600 rounded-full flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Diproses</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $totalDiproses }}</h3>
                    <p class="text-xs text-gray-500 mt-1">Menunggu review</p>
                </div>
                <div
                    class="w-14 h-14 bg-linear-to-br from-yellow-500 to-yellow-600 rounded-full flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Disetujui</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $totalDisetujui }}</h3>
                    <p class="text-xs text-gray-500 mt-1">Sudah disetujui</p>
                </div>
                <div
                    class="w-14 h-14 bg-linear-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">SKPP Ditolak</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalDitolak }}</p>
                </div>
                <div
                    class="w-14 h-14 bg-linear-to-br from-red-500 to-red-600 rounded-full flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
            </div>
        </div>

        @if (isset($skppByType))
            <div class="bg-gray-700 rounded shadow-lg p-6 text-white">
                <h3 class="text-lg font-semibold mb-4">Total SKPP per Tipe</h3>
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="text-sm opacity-90">Pensiun</span>
                        <span class="font-bold text-lg">{{ $skppByType['pensiun'] ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm opacity-90">Meninggal Dunia</span>
                        <span class="font-bold text-lg">{{ $skppByType['meninggal_dunia'] ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm opacity-90">Mutasi</span>
                        <span class="font-bold text-lg">{{ $skppByType['mutasi'] ?? 0 }}</span>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white rounded shadow-sm p-6 border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.skpp.index') }}?status=diproses"
                    class="flex items-center text-sm text-gray-700 hover:text-blue-800 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    Review SKPP Terbaru
                </a>
                <a href="{{ route('admin.skpp.index') }}"
                    class="flex items-center text-sm text-gray-700 hover:text-blue-800 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    Lihat Semua SKPP
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-300">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">SKPP Terbaru</h2>
                    <p class="text-sm text-gray-600 mt-1">pengajuan terakhir</p>
                </div>
                <a href="{{ route('admin.skpp.index') }}"
                    class="px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded hover:bg-gray-700 transition">
                    Lihat Semua
                </a>
            </div>
        </div>

        <div class="w-full overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden border border-gray-100 rounded">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    No. Urut
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Diajukan Oleh
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Tipe
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Data Pegawai
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Status
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Tanggal
                                </th>
                                <th class="px-6 py-4"></th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-300">
                            @forelse ($recentSkpp as $skpp)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-bold text-gray-800">
                                            {{ str_pad($skpp->nomor_urut, 3, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-800">{{ $skpp->user->nama }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($skpp->tipe == 'pensiun')
                                            <span
                                                class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Pensiun</span>
                                        @elseif($skpp->tipe == 'meninggal_dunia')
                                            <span
                                                class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Meninggal
                                                Dunia</span>
                                        @else
                                            <span
                                                class="px-3 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">Mutasi</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-800">{{ $skpp->nama }}</div>
                                        <div class="text-xs text-gray-500">{{ $skpp->nip }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($skpp->status == 'diproses')
                                            <span
                                                class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Diproses</span>
                                        @elseif($skpp->status == 'disetujui')
                                            <span
                                                class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                        @else
                                            <span
                                                class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $skpp->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="whitespace-nowrap text-center">
                                        <a href="{{ route('admin.skpp.show', $skpp) }}"
                                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-xs font-medium rounded-lg hover:bg-blue-700 transition">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="text-gray-500 font-medium">Belum ada pengajuan SKPP</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
