@extends('layouts.app')

@section('title', 'Riwayat Pengajuan')

@section('content')
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Riwayat Pengajuan</h1>
            <p class="text-gray-600 mt-2">Kelola dan lihat semua status pengajuan SKPP Anda</p>
        </div>
    </div>

    @if ($skpps->isEmpty())
        <div class="bg-white rounded shadow p-12 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="text-gray-300 w-16 h-16 mb-4 mx-auto">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M19.5 14.25v-2.625a2.625 2.625 0 00-2.625-2.625h-9.75A2.625 2.625 0 004.5 11.625V14.25m12 0V15a4.5 4.5 0 11-9 0v-.75m12 0H4.5" />
            </svg>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum Ada Pengajuan</h3>
            <p class="text-gray-600 mb-6">Anda belum membuat SKPP. Mulai dengan membuat SKPP baru.</p>
            <a href="{{ route('skpp.create') }}"
                class="inline-block bg-green-600 text-white px-6 py-3 rounded font-semibold hover:bg-green-700 transition">
                Buat SKPP Pertama
            </a>
        </div>
    @else
        <div class="bg-white/70 backdrop-blur-xl rounded shadow-lg overflow-hidden border border-gray-200">
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-linear-to-r from-green-700 to-green-600">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">No.
                                Urut</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Tipe
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Nama
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">NIP
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Status
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider"></th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach ($skpps as $skpp)
                            <tr class="hover:bg-gray-50/70 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-700">
                                    {{ str_pad($skpp->nomor_urut, 3, '0', STR_PAD_LEFT) }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($skpp->tipe == 'pensiun')
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700 shadow-sm">
                                            Pensiun
                                        </span>
                                    @elseif($skpp->tipe == 'meninggal_dunia')
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700 shadow-sm">
                                            Meninggal Dunia
                                        </span>
                                    @else
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-700 shadow-sm">
                                            Mutasi
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $skpp->nama }}</td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $skpp->nip }}</td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($skpp->status == 'diproses')
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700 shadow-sm">
                                            Diproses
                                        </span>
                                    @elseif($skpp->status == 'disetujui')
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700 shadow-sm">
                                            Disetujui
                                        </span>
                                    @else
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700 shadow-sm">
                                            Ditolak
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $skpp->created_at->format('d/m/Y') }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <a href="{{ route('skpp.show', $skpp) }}"
                                        class="inline-flex items-center px-4 py-2 bg-green-700 text-white text-xs font-semibold rounded-lg hover:bg-green-800 transition shadow-sm">
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
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="md:hidden p-4 space-y-4">
                @foreach ($skpps as $skpp)
                    <div class="border rounded shadow-md p-4 bg-white/80 backdrop-blur">
                        <div class="flex justify-between items-center mb-2">
                            <h2 class="font-bold text-gray-800 text-lg">
                                No. {{ str_pad($skpp->nomor_urut, 3, '0', STR_PAD_LEFT) }}
                            </h2>

                            @if ($skpp->status == 'diproses')
                                <span
                                    class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">Diproses</span>
                            @elseif($skpp->status == 'disetujui')
                                <span
                                    class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">Disetujui</span>
                            @else
                                <span
                                    class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">Ditolak</span>
                            @endif
                        </div>

                        <p class="text-sm"><span class="font-semibold">Nama:</span> {{ $skpp->nama }}</p>
                        <p class="text-sm"><span class="font-semibold">NIP:</span> {{ $skpp->nip }}</p>

                        <p class="mt-1 text-sm">
                            <span class="font-semibold">Tipe:</span>
                            @if ($skpp->tipe == 'pensiun')
                                <span
                                    class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">Pensiun</span>
                            @elseif($skpp->tipe == 'meninggal_dunia')
                                <span
                                    class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700">Meninggal
                                    Dunia</span>
                            @else
                                <span
                                    class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-700">Mutasi</span>
                            @endif
                        </p>

                        <p class="mt-2 text-gray-600 text-sm">
                            <span class="font-semibold">Tanggal:</span> {{ $skpp->created_at->format('d/m/Y') }}
                        </p>

                        <div class="mt-3">
                            <a href="{{ route('skpp.show', $skpp) }}"
                                class="inline-block w-full text-center px-4 py-2 bg-green-700 text-white text-xs font-semibold rounded-lg hover:bg-green-800 transition shadow-sm">
                                Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection
