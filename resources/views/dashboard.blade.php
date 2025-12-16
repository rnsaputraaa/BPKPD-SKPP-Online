@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
            <p class="text-gray-600 mt-1">Selamat datang, {{ auth()->user()->nama }}</p>
        </div>

        <a href="{{ route('user.edit-profile') }}"
            class="group px-5 py-2.5 rounded border border-gray-300 hover:border-green-700 text-gray-700 hover:text-green-700 flex items-center space-x-2 transition-all duration-200 hover:shadow-md bg-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="font-medium">Profile Saya</span>
            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Pengajuan</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">
                        {{ \App\Models\Skpp::where('user_id', auth()->id())->count() }}</h3>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Menunggu Proses</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">
                        {{ \App\Models\Skpp::where('user_id', auth()->id())->where('status', 'diproses')->count() }}</h3>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Disetujui</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">
                        {{ \App\Models\Skpp::where('user_id', auth()->id())->where('status', 'disetujui')->count() }}</h3>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded shadow overflow-hidden">
        <div class="p-6 bg-green-700 text-white flex justify-between items-center">
            <h2 class="text-xl font-bold">Pengajuan Terbaru</h2>
            <a href="{{ route('skpp.index') }}" class="text-sm underline hover:opacity-80">
                Lihat Semua
            </a>
        </div>

        @php
            $recentSkpps = \App\Models\Skpp::where('user_id', auth()->id())
                ->latest()
                ->take(3)
                ->get();
        @endphp

        @if ($recentSkpps->isEmpty())
            <div class="p-12 text-center">
                <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Belum ada pengajuan</h3>
                <a href="{{ route('skpp.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition mt-4">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Buat Pengajuan Baru
                </a>
            </div>
        @else
            <div class="divide-y divide-gray-200">
                @foreach ($recentSkpps as $skpp)
                    <div class="p-6 hover:bg-gray-50 transition">
                        <div class="flex items-start justify-between">
                            <div class="flex-1 grid grid-cols-1 md:grid-cols-4 gap-6">
                                <div>
                                    <p class="text-xs text-gray-500 mb-2">Tipe SKPP</p>
                                    <div class="flex flex-wrap gap-2">
                                        @if ($skpp->tipe == 'pensiun')
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Pensiun
                                            </span>
                                        @elseif($skpp->tipe == 'meninggal_dunia')
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Meninggal Dunia
                                            </span>
                                        @else
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                                Mutasi
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="md:col-span-2">
                                    <p class="text-xs text-gray-500 mb-2">Data Pegawai</p>
                                    <p class="text-base font-semibold text-gray-900">{{ $skpp->nama }}</p>
                                    <p class="text-sm text-gray-600 mt-1">NIP: {{ $skpp->nip }}</p>
                                </div>

                                <div>
                                    <p class="text-xs text-gray-500 mb-2">Status & Tanggal</p>
                                    @if ($skpp->status == 'diproses')
                                        <span
                                            class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 mb-2">
                                            Diproses
                                        </span>
                                    @elseif($skpp->status == 'disetujui')
                                        <span
                                            class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 mb-2">
                                            Disetujui
                                        </span>
                                    @else
                                        <span
                                            class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 mb-2">
                                            Ditolak
                                        </span>
                                    @endif
                                    <p class="text-sm text-gray-600 mt-2">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $skpp->created_at->locale('id')->translatedFormat('d F Y') }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2 ml-6">
                                <a href="{{ route('skpp.show', $skpp) }}"
                                    class="inline-flex items-center px-4 py-2 bg-green-700 text-white text-xs font-medium rounded-lg hover:bg-green-800 transition">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="mt-8 bg-blue-100 border-l-4 border-blue-500 p-6 rounded">
        <div class="flex">
            <div class="shrink-0">
                <svg class="w-6 h-6 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Informasi</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <p>Sistem SKPP Online memudahkan Anda dalam mengajukan Surat Keterangan Penghentian Pembayaran secara
                        digital.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
