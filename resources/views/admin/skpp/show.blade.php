@extends('layouts.admin')

@section('title', 'Detail SKPP')

@section('content')
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Detail SKPP</h1>
                <p class="text-gray-600 mt-1">
                    Nomor Surat: <span
                        class="font-semibold">{{ str_pad($skpp->nomor_urut, 3, '0', STR_PAD_LEFT) }}/{{ $skpp->kode_wilayah }}/{{ $skpp->tahun_surat }}</span>
                </p>
            </div>
            <div class="flex gap-3">
                @if ($skpp->status == 'disetujui')
                    <a href="{{ route('admin.skpp.print', $skpp) }}"
                        class="inline-flex items-center px-6 py-3 bg-blue-600 text-white text-sm font-semibold rounded hover:bg-blue-700 transition shadow-md">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Cetak Dokumen
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-3">
                <p class="text-sm font-medium text-gray-600">Status Pengajuan</p>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            @if ($skpp->status == 'diproses')
                <span class="inline-flex items-center px-4 py-2 text-sm font-bold rounded-full bg-blue-100 text-blue-800">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                            clip-rule="evenodd" />
                    </svg>
                    DIPROSES
                </span>
            @elseif($skpp->status == 'disetujui')
                <span class="inline-flex items-center px-4 py-2 text-sm font-bold rounded-full bg-green-100 text-green-800">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    DISETUJUI
                </span>
            @else
                <span class="inline-flex items-center px-4 py-2 text-sm font-bold rounded-full bg-red-100 text-red-800">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                    DITOLAK
                </span>
            @endif
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-3">
                <p class="text-sm font-medium text-gray-600">Diajukan Oleh</p>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div class="flex items-center">
                <div>
                    <p class="font-bold text-gray-900">{{ $skpp->user->nama }}</p>
                    <p class="text-sm text-gray-600">NIP: {{ $skpp->user->nip }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-3">
                <p class="text-sm font-medium text-gray-600">Tanggal Pengajuan</p>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <p class="font-bold text-gray-900 text-lg">{{ $skpp->created_at->format('d/m/Y') }}</p>
        </div>
    </div>

    @if ($skpp->status == 'diproses')
        <div class="bg-linear-to-r from-blue-50 to-purple-50 rounded-xl shadow-sm border border-blue-100 p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-1">Keputusan Pengajuan</h2>
                    <p class="text-sm text-gray-600">Setujui atau tolak pengajuan SKPP ini</p>
                </div>
                <div class="flex gap-3">
                    <form action="{{ route('admin.skpp.approve', $skpp) }}" method="POST"
                        onsubmit="return confirm('Apakah Anda yakin ingin menyetujui SKPP ini?')">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-green-600 text-white text-sm font-semibold rounded hover:bg-green-700 transition shadow-md">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Setujui SKPP
                        </button>
                    </form>

                    <button onclick="showRejectModal()"
                        class="inline-flex items-center px-6 py-3 bg-red-600 text-white text-sm font-semibold rounded hover:bg-red-700 transition shadow-md">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Tolak SKPP
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if ($skpp->status == 'ditolak' && $skpp->alasan_penolakan)
        <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded mb-6 shadow-sm">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-red-500 mr-3 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                </svg>
                <div>
                    <h3 class="font-bold text-red-800 text-lg mb-2">Alasan Penolakan</h3>
                    <p class="text-red-700">{{ $skpp->alasan_penolakan }}</p>
                    @if ($skpp->approved_by && $skpp->approved_at)
                        <p class="text-sm text-red-600 mt-2">
                            Ditolak oleh: <span
                                class="font-semibold">{{ optional($skpp->approver)->nama ?? 'Admin' }}</span>
                            pada {{ $skpp->approved_at->locale('id')->translatedFormat('d F Y') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    @endif

    @if ($skpp->status == 'disetujui' && $skpp->approved_by && $skpp->approved_at)
        <div class="bg-green-50 border-l-4 border-green-500 p-6 rounded mb-6 shadow-sm">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-green-500 mr-3 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <div>
                    <h3 class="font-bold text-green-800 text-lg mb-1">SKPP Telah Disetujui</h3>
                    <p class="text-sm text-green-700">
                        Disetujui oleh: <span
                            class="font-semibold">{{ optional($skpp->approver)->nama ?? 'Admin' }}</span>
                        pada {{ $skpp->approved_at->locale('id')->translatedFormat('d F Y') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white rounded shadow p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Data Pegawai</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-600">NIP</p>
                <p class="font-semibold text-gray-800">{{ $skpp->nip }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Nama</p>
                <p class="font-semibold text-gray-800">{{ $skpp->nama }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Tanggal Lahir</p>
                <p class="font-semibold text-gray-800">{{ $skpp->tanggal_lahir->locale('id')->translatedFormat('d F Y') }}
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Golongan</p>
                <p class="font-semibold text-gray-800">{{ $skpp->golongan }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Jabatan</p>
                <p class="font-semibold text-gray-800">{{ $skpp->jabatan }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Unit Kerja</p>
                <p class="font-semibold text-gray-800">{{ $skpp->unit_kerja }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded shadow p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Data Surat Keputusan</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-600">SK Dari</p>
                <p class="font-semibold text-gray-800">{{ $skpp->sk_dari }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Nomor SK</p>
                <p class="font-semibold text-gray-800">{{ $skpp->sk_nomor }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Tanggal SK</p>
                <p class="font-semibold text-gray-800">{{ $skpp->sk_tanggal->locale('id')->translatedFormat('d F Y') }}
                </p>
            </div>

            @if ($skpp->tipe == 'pensiun')
                <div>
                    <p class="text-sm text-gray-600">Tanggal Mulai</p>
                    <p class="font-semibold text-gray-800">
                        {{ $skpp->tanggal_mulai ? $skpp->tanggal_mulai->locale('id')->translatedFormat('d F Y') : '-' }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Pensiun Pokok</p>
                    <p class="font-semibold text-gray-800">Rp
                        {{ number_format($skpp->pensiun_pokok, 0, ',', '.') }}</p>
                </div>
            @elseif($skpp->tipe == 'meninggal_dunia')
                <div>
                    <p class="text-sm text-gray-600">Tanggal Meninggal</p>
                    <p class="font-semibold text-gray-800">
                        {{ $skpp->tanggal_kematian ? $skpp->tanggal_kematian->locale('id')->translatedFormat('d F Y') : '-' }}
                    </p>
                </div>
            @elseif($skpp->tipe == 'mutasi')
                <div>
                    <p class="text-sm text-gray-600">Tanggal Mulai</p>
                    <p class="font-semibold text-gray-800">
                        {{ $skpp->tanggal_mulai ? $skpp->tanggal_mulai->locale('id')->translatedFormat('d F Y') : '-' }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Pindah Ke</p>
                    <p class="font-semibold text-gray-800">{{ $skpp->pindah_ke }}</p>
                </div>
            @endif
        </div>
    </div>

    <div class="bg-white rounded shadow p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Rincian Gaji</h2>
        <p class="text-sm text-gray-600 mb-4">Gaji dibayarkan sampai: <span
                class="font-semibold text-gray-800">{{ $skpp->gaji_sampai_bulan }}</span></p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="font-bold text-green-700 mb-3">A. Penerimaan</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span>Gaji Pokok:</span><span>Rp
                            {{ number_format($skpp->gaji_pokok, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Tunjangan Istri/Suami:</span><span>Rp
                            {{ number_format($skpp->tun_pasangan, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Tunjangan Anak:</span><span>Rp
                            {{ number_format($skpp->tun_anak, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Tunjangan Perbaikan Penghasilan:</span><span>Rp
                            {{ number_format($skpp->tun_pp, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Tunjangan Struktural:</span><span>Rp
                            {{ number_format($skpp->tun_struktural, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Tunjangan Fungsional:</span><span>Rp
                            {{ number_format($skpp->tun_fungsional, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Tunjangan Beras:</span><span>Rp
                            {{ number_format($skpp->tun_beras, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Tunjangan Umum:</span><span>Rp
                            {{ number_format($skpp->tun_umum, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Tunjangan Fungsi Khusus:</span><span>Rp
                            {{ number_format($skpp->tun_fk, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Tunjangan Kemahalan Daerah:</span><span>Rp
                            {{ number_format($skpp->tun_mahal, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Tunjangan Daerah Terpencil:</span><span>Rp
                            {{ number_format($skpp->tun_terpencil, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Tunjangan BPJS 4%:</span><span>Rp
                            {{ number_format($skpp->tun_bpjs, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Tunjangan Pajak:</span><span>Rp
                            {{ number_format($skpp->tun_pajak, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Tunjangan JKK:</span><span>Rp
                            {{ number_format($skpp->tun_jkk, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Tunjangan JKM:</span><span>Rp
                            {{ number_format($skpp->tun_jkm, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Tunjangan Tapera PK:</span><span>Rp
                            {{ number_format($skpp->tun_tapera, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Pembulatan:</span><span>Rp
                            {{ number_format($skpp->pembulatan, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between font-bold text-green-700 border-t pt-2 mt-2">
                        <span>Jumlah Kotor:</span><span>Rp
                            {{ number_format($skpp->jumlah_kotor, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="font-bold text-red-700 mb-3">B. Potongan-Potongan</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span>IWP 1%:</span><span>Rp
                            {{ number_format($skpp->iwp_1, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>IWP 8%:</span><span>Rp
                            {{ number_format($skpp->iwp_8, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Potongan BPJS 4%:</span><span>Rp
                            {{ number_format($skpp->pot_bpjs, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Potongan Pajak:</span><span>Rp
                            {{ number_format($skpp->pot_pajak, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Potongan BULOG:</span><span>Rp
                            {{ number_format($skpp->pot_bulog, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Potongan Taperum:</span><span>Rp
                            {{ number_format($skpp->pot_taperum, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Iuran KORPRI:</span><span>Rp
                            {{ number_format($skpp->iuran, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Potongan Sewa Rumah:</span><span>Rp
                            {{ number_format($skpp->pot_sewa, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Potongan Hutang:</span><span>Rp
                            {{ number_format($skpp->pot_hutang, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Potongan JKK:</span><span>Rp
                            {{ number_format($skpp->pot_jkk, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Potongan JKM:</span><span>Rp
                            {{ number_format($skpp->pot_jkm, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Potongan Tapera PK:</span><span>Rp
                            {{ number_format($skpp->pot_tapera, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Potongan Tapera Pegawai:</span><span>Rp
                            {{ number_format($skpp->pot_tapera_peg, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between font-bold text-red-700 border-t pt-2 mt-2">
                        <span>Jumlah Potongan:</span><span>Rp
                            {{ number_format($skpp->jumlah_pot, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 pt-6 border-t">
            <div class="flex justify-between items-center">
                <span class="text-xl font-bold text-gray-800">Jumlah Bersih:</span>
                <span class="text-2xl font-bold text-green-600">Rp
                    {{ number_format($skpp->jumlah_bersih, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    @if ($skpp->keluarga && count($skpp->keluarga) > 0)
        <div class="bg-white rounded shadow p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Daftar Keluarga Tanggungan</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal
                                Lahir</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keterangan
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($skpp->keluarga as $index => $keluarga)
                            <tr>
                                <td class="px-4 py-3 text-sm">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 text-sm font-medium">{{ $keluarga['nama'] }}</td>
                                <td class="px-4 py-3 text-sm">{{ $keluarga['tanggal_lahir'] }}</td>
                                <td class="px-4 py-3 text-sm">{{ $keluarga['keterangan'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    @if ($skpp->jum_hut > 0)
        <div class="bg-white rounded shadow p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Data Hutang</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Jumlah Hutang</p>
                    <p class="font-semibold text-red-600 text-lg">Rp
                        {{ number_format($skpp->jum_hut, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Keterangan</p>
                    <p class="font-semibold text-gray-800">{{ $skpp->ket_hut ?? '-' }}</p>
                </div>
            </div>
        </div>
    @endif

    <div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center p-4">
        <div class="bg-white rounded max-w-md w-full p-6 shadow-2xl">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Tolak SKPP</h3>
                    <p class="text-sm text-gray-600">Berikan alasan penolakan yang jelas</p>
                </div>
            </div>

            <form action="{{ route('admin.skpp.reject', $skpp) }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Alasan Penolakan <span class="text-red-500">*</span>
                    </label>
                    <textarea name="alasan_penolakan" rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"
                        placeholder="Jelaskan alasan mengapa SKPP ditolak" required></textarea>
                    @error('alasan_penolakan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="closeRejectModal()"
                        class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 text-sm font-semibold rounded hover:bg-gray-200 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-3 bg-red-600 text-white text-sm font-semibold rounded hover:bg-red-700 transition">
                        Tolak SKPP
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function showRejectModal() {
            const modal = document.getElementById('rejectModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeRejectModal() {
            const modal = document.getElementById('rejectModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        document.getElementById('rejectModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeRejectModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeRejectModal();
            }
        });

        const modal = document.getElementById('rejectModal');
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === 'class') {
                    const isHidden = modal.classList.contains('hidden');
                    document.body.style.overflow = isHidden ? 'auto' : 'hidden';
                }
            });
        });

        observer.observe(modal, {
            attributes: true
        });
    </script>
@endsection
