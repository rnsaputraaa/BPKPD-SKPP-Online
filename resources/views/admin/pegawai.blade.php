@extends('layouts.admin')

@section('title', 'Daftar Pegawai')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Daftar Pegawai</h1>
        <p class="text-gray-600 mt-1">Lihat seluruh data pegawai terdaftar</p>
    </div>

    <div class="flex justify-center">
        <div class="w-full max-w-6xl bg-white rounded shadow-sm border border-gray-300">

            <div class="p-6 border-b border-gray-100">
                <form method="GET" action="{{ route('admin.pegawai') }}">

                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="relative w-full">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari Nama atau NIP Pegawai"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded
                                   focus:ring-2 focus:ring-gray-600 focus:border-gray-600">

                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>

                        <button type="submit" class="px-6 py-2.5 bg-gray-600 text-white rounded hover:bg-gray-700">
                            Cari
                        </button>
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
                                Hapus Pegawai
                            </th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($pegawai as $index => $peg)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-center">
                                    {{ $pegawai->firstItem() + $index }}
                                </td>
                                <td class="px-6 py-4">{{ $peg->nama }}</td>
                                <td class="px-6 py-4">{{ $peg->nip }}</td>
                                <td class="px-6 py-4">
                                    {{ $peg->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('admin.pegawai.destroy', $peg->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus pegawai ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-600 transition"
                                            title="Hapus Pegawai">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mx-auto" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862 a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6 m2 0H7m3-3h4a1 1 0 011 1v1H9V5a1 1 0 011-1z" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center text-gray-500">
                                    Tidak ada pegawai ditemukan
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
