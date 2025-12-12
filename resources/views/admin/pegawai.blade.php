@extends('layouts.admin')

@section('title', 'Daftar Pegawai')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Daftar Pegawai</h1>
        <p class="text-gray-600 mt-1">Lihat seluruh data pegawai terdaftar</p>
    </div>

    <div class="w-full max-w-5xl bg-white rounded shadow-sm border border-gray-100 p-6 mb-6">
        <form method="GET" action="{{ route('admin.pegawai') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pencarian Pegawai</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari Nama atau NIP Pegawai"
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded focus:ring-2 focus:ring-gray-600 focus:border-gray-600 transition">

                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

            </div>

            <button type="submit"
                class="px-6 py-2.5 bg-gray-600 text-white text-sm font-medium rounded hover:bg-gray-700 transition flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Cari
            </button>
        </form>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded shadow-sm border border-gray-200 p-4">
            <p class="text-xs text-gray-600 mb-1">Total Pegawai</p>
            <p class="text-2xl font-bold text-gray-900">{{ $pegawai->total() }}</p>
        </div>
    </div>

    <div class="w-full max-w-5xl bg-white rounded shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Nama
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            NIP
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Tanggal Daftar
                        </th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($pegawai as $peg)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">{{ $peg->nama }}</td>
                            <td class="px-6 py-4">{{ $peg->nip }}</td>
                            <td class="px-6 py-4">
                                {{ $peg->created_at->format('d/m/Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-gray-500 font-medium text-lg">Tidak ada pegawai ditemukan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($pegawai->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium">{{ $pegawai->firstItem() }}</span> sampai
                        <span class="font-medium">{{ $pegawai->lastItem() }}</span> dari
                        <span class="font-medium">{{ $pegawai->total() }}</span> hasil
                    </div>
                    <div>
                        {{ $pegawai->links() }}
                    </div>
                </div>
            </div>
        @endif

    </div>
@endsection
