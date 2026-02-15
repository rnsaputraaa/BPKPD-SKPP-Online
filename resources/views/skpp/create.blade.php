@extends('layouts.app')

@section('title', 'Buat SKPP Baru')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-8">
        <div class="bg-green-700 shadow-lg rounded overflow-hidden">
            <div class="px-8 py-6 bg-green-600">
                <h1 class="text-2xl md:text-3xl font-extrabold text-white">Buat SKPP Baru</h1>
                <p class="text-sm md:text-base text-white mt-1">Lengkapi form di bawah ini untuk membuat SKPP</p>
            </div>

            <form action="{{ route('skpp.store') }}" method="POST" id="skppForm" class="p-6 space-y-6">
                @csrf

                <div class="bg-white rounded p-5 ">
                    <h2 class="text-lg font-semibold text-green-700 mb-4">Pilih Tipe SKPP</h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        <label class="cursor-pointer">
                            <input type="radio" name="tipe" value="pensiun" class="hidden peer">
                            <div
                                class="border rounded p-4 peer-checked:border-green-600 peer-checked:bg-green-50 hover:border-green-500 transition flex items-center gap-3">
                                <div class="text-green-700 text-2xl">
                                    <i class="fas fa-user-clock"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-green-800">Pensiun</h3>
                                    <p class="text-sm text-green-600">SKPP Pensiun</p>
                                </div>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="tipe" value="meninggal_dunia" class="hidden peer">
                            <div
                                class="border rounded p-4 peer-checked:border-green-600 peer-checked:bg-green-50 hover:border-green-500 transition flex items-center gap-3">
                                <div class="text-green-700 text-2xl">
                                    <i class="fas fa-cross"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-green-800">Meninggal Dunia</h3>
                                    <p class="text-sm text-green-600">SKPP MD</p>
                                </div>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="tipe" value="mutasi" class="hidden peer">
                            <div
                                class="border rounded p-4 peer-checked:border-green-600 peer-checked:bg-green-50 hover:border-green-500 transition flex items-center gap-3">
                                <div class="text-green-700 text-2xl">
                                    <i class="fas fa-exchange-alt"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-green-800">Mutasi</h3>
                                    <p class="text-sm text-green-600">SKPP Mutasi</p>
                                </div>
                            </div>
                        </label>

                    </div>

                    @error('tipe')
                        <small class="text-red-600">{{ $message }}</small>
                    @enderror
                </div>

                <div class="bg-white rounded p-5 ">
                    <h2 class="text-lg font-semibold text-green-700 mb-4">Data Pegawai</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Kode Wilayah <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="kode_wilayah" value="432.402"
                                class="w-full px-4 py-2 rounded focus:ring-2 focus:ring-green-300 focus:border-green-400"
                                required>
                            <p class="text-xs text-gray-500 mt-1">Default: 432.402 (dapat diubah)</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">NIP <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nip" value="{{ auth()->user()->nip }}"
                                class="w-full px-4 py-2 rounded focus:ring-2 focus:ring-green-300 focus:border-green-400 bg-green-50"
                                readonly required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Nama Lengkap<span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nama" value="{{ auth()->user()->nama }}"
                                class="w-full px-4 py-2 rounded focus:ring-2 focus:ring-green-300 focus:border-green-400 bg-green-50"
                                readonly required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Tanggal Lahir <span
                                    class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_lahir"
                                class="w-full px-4 py-2 rounded focus:ring-2 focus:ring-green-300 focus:border-green-400"
                                required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Golongan <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="golongan"
                                class="w-full px-4 py-2 rounded focus:ring-2 focus:ring-green-300 focus:border-green-400"
                                required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Jabatan <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="jabatan"
                                class="w-full px-4 py-2 rounded focus:ring-2 focus:ring-green-300 focus:border-green-400"
                                required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Unit Kerja <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="unit_kerja"
                                class="w-full px-4 py-2 rounded focus:ring-2 focus:ring-green-300 focus:border-green-400"
                                required>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded p-5 ">
                    <h2 class="text-lg font-semibold text-green-700 mb-4">Data Surat Keputusan</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">SK Dari <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="sk_dari" id="sk_dari_select"
                                    class="w-full px-4 py-2 rounded focus:ring-2 focus:ring-green-300 focus:border-green-400 appearance-none cursor-pointer"
                                    onchange="toggleSkDariMode(this)" required>
                                    <option value="" disabled selected>-- Pilih Penerbit SK --</option>
                                    <option value="BUPATI PAMEKASAN">BUPATI PAMEKASAN</option>
                                    <option value="BKP SDM PAMEKASAN">BKP SDM PAMEKASAN</option>
                                    <option value="GUBERNUR JAWA TIMUR">GUBERNUR JAWA TIMUR</option>
                                    <option value="KEPALA BKP SDM">KEPALA BKP SDM</option>
                                    <option value="BKPSDM">BKPSDM</option>
                                    <option value="BKPSDM PAMEKASAN">BKPSDM PAMEKASAN</option>
                                    <option value="kadis">kadis</option>
                                    <option value="KEMENTERIAN PERTANIAN RI">KEMENTERIAN PERTANIAN RI</option>
                                    <option value="MENTERI DALAM NEGERI">MENTERI DALAM NEGERI</option>
                                    <option value="PRESIDEN RI">PRESIDEN RI</option>
                                    <option value="BKD PROVINSI JATIM">BKD PROVINSI JATIM</option>
                                    <option value="DINAS KEPENDUDUKAN DAN CAPIL">DINAS KEPENDUDUKAN DAN CAPIL</option>
                                    <option value="PENCATATAN SIPIL">PENCATATAN SIPIL</option>
                                    <option value="KEPALA DESA">KEPALA DESA</option>
                                    <option value="KEMENTERIAN PERTANIAN">KEMENTERIAN PERTANIAN</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Nomor SK <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="sk_nomor"
                                class="w-full px-4 py-2 rounded focus:ring-2 focus:ring-green-300 focus:border-green-400"
                                required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Tanggal SK <span
                                    class="text-red-500">*</span></label>
                            <input type="date" name="sk_tanggal"
                                class="w-full px-4 py-2 rounded focus:ring-2 focus:ring-green-300 focus:border-green-400"
                                required>
                        </div>

                        <div id="tanggalMulaiField" class="hidden">
                            <label class="block text-sm font-medium text-green-700 mb-2">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai"
                                class="w-full px-4 py-2 rounded focus:ring-2 focus:ring-green-300 focus:border-green-400">
                        </div>
                    </div>

                    <div id="pensiunFields" class="hidden mt-4">
                        <label class="block text-sm font-medium text-green-700 mb-2">Pensiun Pokok</label>
                        <input type="text" name="pensiun_pokok"
                            class="w-full px-4 py-2 rounded money focus:ring-2 focus:ring-green-300 focus:border-green-400">
                    </div>

                    <div id="meninggalFields" class="hidden mt-4">
                        <label class="block text-sm font-medium text-green-700 mb-2">Tanggal Meninggal</label>
                        <input type="date" name="tanggal_kematian"
                            class="w-full px-4 py-2 rounded focus:ring-2 focus:ring-green-300 focus:border-green-400">
                    </div>

                    <div id="mutasiFields" class="hidden mt-4">
                        <label class="block text-sm font-medium text-green-700 mb-2">Pindah Ke</label>
                        <input type="text" name="pindah_ke"
                            class="w-full px-4 py-2 rounded focus:ring-2 focus:ring-green-300 focus:border-green-400">
                    </div>
                </div>

                <div class="bg-white rounded-xl p-5 ">
                    <h2 class="text-lg font-semibold text-green-700 mb-4">Informasi Gaji</h2>
                    <div>
                        <label class="block text-sm font-medium text-green-700 mb-2">Gaji Dibayarkan Sampai Bulan <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="gaji_sampai_bulan" placeholder="Contoh: Desember 2025"
                            class="placeholder-mobile w-full px-4 py-2 rounded focus:ring-2 focus:ring-green-300 focus:border-green-400"
                            required>
                    </div>
                </div>

                <div class="bg-white rounded p-5 ">
                    <h2 class="text-lg font-semibold text-green-700 mb-4">A. Penerimaan</h2>
                    <p class="text-sm text-bold text-green-600 mb-4">Kosongkan jika tidak ada <span
                            class="text-red-500">*</span></p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Gaji Pokok</label>
                            <input type="text" step="0.01" name="gaji_pokok"
                                class="w-full px-4 py-2 rounded money focus:ring-2 focus:ring-green-300 focus:border-green-400">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Tunjangan Istri/Suami</label>
                            <input type="text" step="0.01" name="tun_pasangan"
                                class="w-full px-4 py-2 rounded money focus:ring-2 focus:ring-green-300 focus:border-green-400">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Tunjangan Anak</label>
                            <input type="text" step="0.01" name="tun_anak"
                                class="w-full px-4 py-2 rounded money focus:ring-2 focus:ring-green-300 focus:border-green-400">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Tunjangan Perbaikan
                                Penghasilan</label>
                            <input type="text" step="0.01" name="tun_pp"
                                class="w-full px-4 py-2 rounded money focus:ring-2 focus:ring-green-300 focus:border-green-400">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Tunjangan Struktural</label>
                            <input type="text" step="0.01" name="tun_struktural"
                                class="w-full px-4 py-2 rounded money focus:ring-2 focus:ring-green-300 focus:border-green-400">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Tunjangan Fungsional</label>
                            <input type="text" step="0.01" name="tun_fungsional"
                                class="w-full px-4 py-2 rounded money focus:ring-2 focus:ring-green-300 focus:border-green-400">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Tunjangan Beras</label>
                            <input type="text" step="0.01" name="tun_beras"
                                class="w-full px-4 py-2 rounded money focus:ring-2 focus:ring-green-300 focus:border-green-400">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Tunjangan Umum</label>
                            <input type="text" step="0.01" name="tun_umum"
                                class="w-full px-4 py-2 rounded money focus:ring-2 focus:ring-green-300 focus:border-green-400">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Tunjangan Fungsi Khusus</label>
                            <input type="text" step="0.01" name="tun_fk"
                                class="w-full px-4 py-2 rounded money focus:ring-2 focus:ring-green-300 focus:border-green-400">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Tunjangan Kemahalan Daerah</label>
                            <input type="text" step="0.01" name="tun_mahal"
                                class="w-full px-4 py-2 rounded money focus:ring-2 focus:ring-green-300 focus:border-green-400">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Tunjangan Daerah Terpencil</label>
                            <input type="text" step="0.01" name="tun_terpencil"
                                class="w-full px-4 py-2 rounded money focus:ring-2 focus:ring-green-300 focus:border-green-400">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Tunjangan BPJS 4%</label>
                            <input type="text" step="0.01" name="tun_bpjs"
                                class="w-full px-4 py-2 rounded money focus:ring-2 focus:ring-green-300 focus:border-green-400">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Tunjangan Pajak</label>
                            <input type="text" step="0.01" name="tun_pajak"
                                class="w-full px-4 py-2 rounded money focus:ring-2 focus:ring-green-300 focus:border-green-400">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Tunjangan JKK</label>
                            <input type="text" step="0.01" name="tun_jkk"
                                class="w-full px-4 py-2 rounded money focus:ring-2 focus:ring-green-300 focus:border-green-400">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Tunjangan JKM</label>
                            <input type="text" step="0.01" name="tun_jkm"
                                class="w-full px-4 py-2 rounded money focus:ring-2 focus:ring-green-300 focus:border-green-400">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Tunjangan Tapera PK</label>
                            <input type="text" step="0.01" name="tun_tapera"
                                class="w-full px-4 py-2 rounded money focus:ring-2 focus:ring-green-300 focus:border-green-400">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Pembulatan</label>
                            <input type="text" step="0.01" name="pembulatan"
                                class="w-full px-4 py-2 rounded money focus:ring-2 focus:ring-green-300 focus:border-green-400">
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded p-5 ">
                    <h2 class="text-lg font-semibold text-green-700 mb-4">B. Potongan-Potongan</h2>
                    <p class="text-sm text-bold text-green-600 mb-4">Kosongkan jika tidak ada <span
                            class="text-red-500">*</span></p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">IWP 1%</label>
                            <input type="text" step="0.01" name="iwp_1"
                                class="w-full px-4 py-2 rounded money focus:ring-2 focus:ring-green-300 focus:border-green-400">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">IWP 8%</label>
                            <input type="text" step="0.01" name="iwp_8"
                                class="w-full px-4 py-2 rounded money focus:ring-2 focus:ring-green-300 focus:border-green-400">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Potongan BPJS 4%</label>
                            <input type="text" step="0.01" name="pot_bpjs"
                                class="w-full px-4 py-2 rounded money focus:ring-2 focus:ring-green-300 focus:border-green-400">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Potongan Pajak</label>
                            <input type="text" step="0.01" name="pot_pajak"
                                class="w-full px-4 py-2 rounded money focus:ring-2 focus:ring-green-300 focus:border-green-400">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Potongan BULOG</label>
                            <input type="text" step="0.01" name="pot_bulog"
                                class="w-full px-4 py-2 rounded money focus:ring-2 focus:ring-green-300 focus:border-green-400">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Potongan Taperum</label>
                            <input type="text" step="0.01" name="pot_taperum"
                                class="w-full px-4 py-2 rounded money focus:ring-2 focus:ring-green-300 focus:border-green-400">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Iuran KORPRI</label>
                            <input type="text" step="0.01" name="iuran"
                                class="w-full px-4 py-2 rounded money focus:ring-2 focus:ring-green-300 focus:border-green-400">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Potongan Sewa Rumah</label>
                            <input type="text" step="0.01" name="pot_sewa"
                                class="w-full px-4 py-2 rounded money focus:ring-2 focus:ring-green-300 focus:border-green-400">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Potongan Hutang</label>
                            <input type="text" step="0.01" name="pot_hutang"
                                class="w-full px-4 py-2 rounded money focus:ring-2 focus:ring-green-300 focus:border-green-400">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Potongan JKK</label>
                            <input type="text" step="0.01" name="pot_jkk"
                                class="w-full px-4 py-2 rounded money focus:ring-2 focus:ring-green-300 focus:border-green-400">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Potongan JKM</label>
                            <input type="text" step="0.01" name="pot_jkm"
                                class="w-full px-4 py-2 rounded money focus:ring-2 focus:ring-green-300 focus:border-green-400">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Potongan Tapera PK</label>
                            <input type="text" step="0.01" name="pot_tapera"
                                class="w-full px-4 py-2 rounded money focus:ring-2 focus:ring-green-300 focus:border-green-400">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Potongan Tapera Pegawai</label>
                            <input type="text" step="0.01" name="pot_tapera_peg"
                                class="w-full px-4 py-2 rounded money focus:ring-2 focus:ring-green-300 focus:border-green-400">
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded p-5 ">
                    <h2 class="text-lg font-semibold text-green-700 mb-4">Daftar Keluarga Tanggungan</h2>
                    <p class="text-sm text-bold text-green-600 mb-4">Kosongkan jika tidak ada <span
                            class="text-red-500">*</span></p>

                    <div class="space-y-4">
                        @for ($i = 1; $i <= 5; $i++)
                            <div class="rounded p-4">
                                <h3 class="font-semibold text-green-700 mb-3">Anggota Keluarga {{ $i }}</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-green-700 mb-2">Nama</label>
                                        <input type="text" name="nama_keluarga{{ $i }}"
                                            class="w-full px-4 py-2 rounded focus:ring-2 focus:ring-green-300 focus:border-green-400">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-green-700 mb-2">Tanggal Lahir</label>
                                        <input type="date" name="lahir{{ $i }}"
                                            class="w-full px-4 py-2 rounded focus:ring-2 focus:ring-green-300 focus:border-green-400">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-green-700 mb-2">Keterangan</label>
                                        <input type="text" name="ket{{ $i }}"
                                            placeholder="Contoh: Istri, Anak ke-1"
                                            class="placeholder-mobile w-full px-4 py-2 rounded focus:ring-2 focus:ring-green-300 focus:border-green-400">
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>

                <div class="bg-white rounded p-5 ">
                    <h2 class="text-lg font-semibold text-green-700 mb-4">Data Hutang</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Jumlah Hutang</label>
                            <input type="text" name="jum_hut"
                                class="w-full px-4 py-2 rounded money focus:ring-2 focus:ring-green-300 focus:border-green-400">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-2">Keterangan Hutang</label>
                            <textarea name="ket_hut" rows="3"
                                class="w-full px-4 py-2 rounded focus:ring-2 focus:ring-green-300 focus:border-green-400"></textarea>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('skpp.index') }}"
                        class="px-6 py-3 rounded bg-white text-green-600 font-semibold hover:bg-green-100 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-3 bg-green-600 text-white rounded font-semibold hover:bg-green-700 transition shadow">
                        Ajukan Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleSkDariMode(selectElement) {
            const selectArrow = document.getElementById('select_arrow');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const selectElement = document.getElementById('sk_dari_select');
            const oldValue = '{{ old('sk_dari') }}';
        });

        document.addEventListener('DOMContentLoaded', function() {
            const tipeInputs = document.querySelectorAll('input[name="tipe"]');
            const tanggalMulaiField = document.getElementById('tanggalMulaiField');
            const pensiunFields = document.getElementById('pensiunFields');
            const meninggalFields = document.getElementById('meninggalFields');
            const mutasiFields = document.getElementById('mutasiFields');
            const moneyInputs = document.querySelectorAll('.money');

            tipeInputs.forEach(input => {
                input.addEventListener('change', function() {
                    tanggalMulaiField.classList.add('hidden');
                    pensiunFields.classList.add('hidden');
                    meninggalFields.classList.add('hidden');
                    mutasiFields.classList.add('hidden');

                    if (this.value === 'pensiun') {
                        tanggalMulaiField.classList.remove('hidden');
                        pensiunFields.classList.remove('hidden');
                    } else if (this.value === 'meninggal_dunia') {
                        meninggalFields.classList.remove('hidden');
                    } else if (this.value === 'mutasi') {
                        tanggalMulaiField.classList.remove('hidden');
                        mutasiFields.classList.remove('hidden');
                    }
                });
            });

            function formatRupiah(angka) {
                if (!angka) return '';

                let numberString = angka.toString().replace(/[^,\d]/g, '');
                let split = numberString.split(',');
                let sisa = split[0].length % 3;
                let rupiah = split[0].substr(0, sisa);
                let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    let separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return rupiah;
            }

            moneyInputs.forEach(input => {
                if (input.value && input.value.trim() !== '') {
                    input.value = formatRupiah(input.value);
                }

                input.addEventListener('keyup', function(e) {
                    let value = this.value;
                    this.value = formatRupiah(value);
                });
            });

            const form = document.getElementById('skppForm');

            form.addEventListener('submit', function(ev) {
                moneyInputs.forEach(input => {
                    if (input.value && input.value.trim() !== '') {
                        let raw = input.value.replace(/\./g, '').replace(/,/g, '.');
                        input.value = raw;
                    }
                });

                setTimeout(() => {
                    form.reset();

                    tanggalMulaiField.classList.add('hidden');
                    pensiunFields.classList.add('hidden');
                    meninggalFields.classList.add('hidden');
                    mutasiFields.classList.add('hidden');
                }, 100);
            });
        });
    </script>
@endsection
