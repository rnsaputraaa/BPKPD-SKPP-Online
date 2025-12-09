@extends('layouts.app')

@section('title', 'Detail SKPP')

@section('content')
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Detail SKPP</h1>
            <p class="text-gray-600 mt-2">Nomor:
                {{ str_pad($skpp->nomor_urut, 3, '0', STR_PAD_LEFT) }}/{{ $skpp->kode_wilayah }}/{{ $skpp->tahun_surat }}
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded shadow p-6">
            <div class="flex items-center">
                <div>
                    <p class="text-sm text-gray-600">Tipe SKPP</p>
                    <p class="text-lg font-bold text-gray-800 capitalize">{{ str_replace('_', ' ', $skpp->tipe) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded shadow p-6">
            <div class="flex items-center">
                <div>
                    <p class="text-sm text-gray-600">Status</p>
                    <p class="text-lg font-bold text-gray-800 capitalize">{{ $skpp->status }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded shadow p-6">
            <div class="flex items-center">
                <div>
                    <p class="text-sm text-gray-600">Tanggal Dibuat</p>
                    <p class="text-lg font-bold text-gray-800">{{ $skpp->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>
    </div>

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
                <p class="font-semibold text-gray-800">{{ $skpp->sk_tanggal->locale('id')->translatedFormat('d F Y') }}</p>
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
                    <p class="font-semibold text-gray-800">Rp {{ number_format($skpp->pensiun_pokok, 0, ',', '.') }}</p>
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
                        <span>Jumlah Kotor:</span><span>Rp {{ number_format($skpp->jumlah_kotor, 0, ',', '.') }}</span>
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
                        <span>Jumlah Potongan:</span><span>Rp {{ number_format($skpp->jumlah_pot, 0, ',', '.') }}</span>
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
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Lahir</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
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
                    <p class="font-semibold text-red-600 text-lg">Rp {{ number_format($skpp->jum_hut, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Keterangan</p>
                    <p class="font-semibold text-gray-800">{{ $skpp->ket_hut ?? '-' }}</p>
                </div>
            </div>
        </div>
    @endif
@endsection
