@extends('layouts.admin')

@section('title', 'Kelola Pengajuan')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Daftar Semua Pengajuan</h1>
        <p class="text-gray-600 mt-1">Kelola dan review pengajuan SKPP dari semua user</p>
    </div>

    <div class="bg-white rounded shadow-sm border border-gray-100 p-6 mb-6">
        <form method="GET" action="{{ route('admin.skpp.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pencarian</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama, nip, atau nomor urut"
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded focus:ring-2 focus:ring-gray-600 focus:border-gray-600 transition">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded focus:ring-2 focus:ring-gray-600 focus:border-gray-600 transition">
                        <option value="">Semua Status</option>
                        <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui
                        </option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipe SKPP</label>
                    <select name="tipe"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded focus:ring-2 focus:ring-gray-600 focus:border-gray-600 transition">
                        <option value="">Semua Tipe</option>
                        <option value="pensiun" {{ request('tipe') == 'pensiun' ? 'selected' : '' }}>Pensiun</option>
                        <option value="meninggal_dunia" {{ request('tipe') == 'meninggal_dunia' ? 'selected' : '' }}>
                            Meninggal Dunia</option>
                        <option value="mutasi" {{ request('tipe') == 'mutasi' ? 'selected' : '' }}>Mutasi</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                    class="px-6 py-2.5 bg-gray-600 text-white text-sm font-medium rounded hover:bg-gray-700 transition flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Cari
                </button>
                <a href="{{ route('admin.skpp.index') }}"
                    class="px-6 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded hover:bg-gray-300 transition flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white rounded shadow-sm border border-gray-200 p-4">
            <p class="text-xs text-gray-600 mb-1">Total</p>
            <p class="text-2xl font-bold text-gray-900">{{ $skpps->total() }}</p>
        </div>
        <div class="bg-yellow-50 rounded border border-yellow-200 p-4">
            <p class="text-xs text-yellow-700 mb-1">Diproses</p>
            <p class="text-2xl font-bold text-yellow-800">
                {{ $skpps->where('status', 'diproses')->count() }}
            </p>
        </div>
        <div class="bg-green-50 rounded border border-green-200 p-4">
            <p class="text-xs text-green-700 mb-1">Disetujui</p>
            <p class="text-2xl font-bold text-green-800">
                {{ $skpps->where('status', 'disetujui')->count() }}
            </p>
        </div>
        <div class="bg-red-50 rounded border border-red-200 p-4">
            <p class="text-xs text-red-700 mb-1">Ditolak</p>
            <p class="text-2xl font-bold text-red-800">
                {{ $skpps->where('status', 'ditolak')->count() }}
            </p>
        </div>
    </div>

    <div class="bg-white rounded shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            <a href="{{ route('admin.skpp.index', array_merge(request()->all(), ['sort_by' => 'nomor_urut', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc'])) }}"
                                class="flex items-center hover:text-gray-600 transition">
                                No. Urut
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>
                            </a>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Pengaju
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Tipe
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Data Pegawai
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            <a href="{{ route('admin.skpp.index', array_merge(request()->all(), ['sort_by' => 'created_at', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc'])) }}"
                                class="flex items-center hover:text-gray-600 transition">
                                Tanggal
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>
                            </a>
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($skpps as $skpp)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-bold text-gray-900">
                                    {{ str_pad($skpp->nomor_urut, 3, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $skpp->user->nama }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($skpp->tipe == 'pensiun')
                                    <span
                                        class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 inline-flex items-center">
                                        Pensiun
                                    </span>
                                @elseif($skpp->tipe == 'meninggal_dunia')
                                    <span
                                        class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 inline-flex items-center">
                                        Meninggal Dunia
                                    </span>
                                @else
                                    <span
                                        class="px-3 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800 inline-flex items-center">
                                        Mutasi
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $skpp->nama }}</div>
                                <div class="text-xs text-gray-500">{{ $skpp->nip }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($skpp->status == 'diproses')
                                    <span
                                        class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Diproses
                                    </span>
                                @elseif($skpp->status == 'disetujui')
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Disetujui
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $skpp->created_at->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <a href="{{ route('admin.skpp.show', $skpp) }}"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-xs font-medium rounded-lg hover:bg-blue-700 transition">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            <td colspan="7" class="px-6 py-16 text-center">
                                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-gray-500 font-medium text-lg">Tidak ada data SKPP ditemukan</p>
                                <p class="text-gray-400 text-sm mt-1">Coba ubah filter pencarian Anda</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($skpps->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium">{{ $skpps->firstItem() }}</span> sampai
                        <span class="font-medium">{{ $skpps->lastItem() }}</span> dari
                        <span class="font-medium">{{ $skpps->total() }}</span> hasil
                    </div>
                    <div>
                        {{ $skpps->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
