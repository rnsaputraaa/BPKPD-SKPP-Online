@extends('layouts.admin')

@section('title', 'Daftar Pegawai')

@section('content')
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Daftar Pegawai</h1>
                <p class="text-gray-600 mt-1">Kelola data pegawai yang dapat mengakses sistem</p>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded relative" role="alert">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded relative" role="alert">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <div class="w-full">
        <div class="w-full bg-white rounded shadow-sm border border-gray-300">
            <div class="p-6 border-b border-gray-100">
                <form method="GET" action="{{ route('admin.pegawai.index') }}">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="flex flex-col sm:flex-row gap-4 flex-1">
                            <div class="relative flex-1">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari Nama atau NIP Pegawai"
                                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded focus:ring-2 focus:ring-gray-500 focus:border-gray-600">

                                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>

                            <button type="submit"
                                class="px-6 py-2.5 bg-gray-600 text-white rounded hover:bg-gray-700 transition whitespace-nowrap">
                                Cari
                            </button>
                        </div>

                        <div class="flex justify-center">
                            <a href="{{ route('admin.pegawai.create') }}"
                                class="px-6 py-2.5 bg-gray-600 text-white rounded hover:bg-gray-700 transition whitespace-nowrap">
                                Tambah Pegawai
                            </a>
                        </div>
                    </div>
                </form>
            </div>


            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase">
                                No
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                                Nama
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                                NIP
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase">
                                Tanggal Daftar
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase">
                                Total Pengajuan
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($pegawai as $index => $peg)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-center text-gray-700">
                                    {{ $pegawai->firstItem() + $index }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $peg->nama }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-300">
                                        {{ $peg->nip }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $peg->created_at->locale('id')->translatedFormat('d F Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 ext-gray-800 border border-gray-300">
                                        {{ $peg->skpp_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.pegawai.edit', $peg) }}"
                                            class="text-blue-600 hover:text-blue-800 transition p-2 rounded hover:bg-blue-50"
                                            title="Edit Pegawai">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('admin.pegawai.destroy', $peg) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus pegawai {{ $peg->nama }}?\n\nData yang terhapus tidak dapat dikembalikan!')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-800 transition p-2 rounded hover:bg-red-50"
                                                title="Hapus Pegawai">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    <p class="mt-4 text-gray-500">
                                        @if (request('search'))
                                            Tidak ada pegawai yang ditemukan dengan kata kunci
                                            "<strong>{{ request('search') }}</strong>"
                                        @else
                                            Belum ada data pegawai
                                        @endif
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($pegawai->hasPages())
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                        <div class="text-sm text-gray-700">
                            Menampilkan
                            <span class="font-medium">{{ $pegawai->firstItem() }}</span>
                            sampai
                            <span class="font-medium">{{ $pegawai->lastItem() }}</span>
                            dari
                            <span class="font-medium">{{ $pegawai->total() }}</span>
                            hasil
                        </div>
                        <div>
                            {{ $pegawai->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
