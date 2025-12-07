@extends('layouts.admin')

@section('title', 'Detail SKPP')

@section('content')
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Detail SKPP</h1>
            <p class="text-gray-600 mt-2">Nomor:
                {{ str_pad($skpp->nomor_urut, 3, '0', STR_PAD_LEFT) }}/{{ $skpp->kode_wilayah }}/{{ $skpp->tahun_surat }}
            </p>
        </div>
        <div class="space-x-3">
            <a href="{{ route('admin.skpp.index') }}"
                class="inline-block bg-gray-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-600 transition">
                Kembali
            </a>
            @if ($skpp->status == 'disetujui')
                <a href="{{ route('admin.skpp.print', $skpp) }}"
                    class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                    Download Word
                </a>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-600 mb-2">Status Pengajuan</p>
            @if ($skpp->status == 'pending')
                <span
                    class="inline-block px-4 py-2 text-sm font-bold rounded-full bg-yellow-100 text-yellow-800">PENDING</span>
            @elseif($skpp->status == 'disetujui')
                <span
                    class="inline-block px-4 py-2 text-sm font-bold rounded-full bg-green-100 text-green-800">DISETUJUI</span>
            @else
                <span class="inline-block px-4 py-2 text-sm font-bold rounded-full bg-red-100 text-red-800">DITOLAK</span>
            @endif
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-600 mb-2">Pengaju</p>
            <p class="font-bold text-gray-800">{{ $skpp->user->nama }}</p>
            <p class="text-sm text-gray-600">NIP: {{ $skpp->user->nip }}</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-600 mb-2">Tanggal Pengajuan</p>
            <p class="font-bold text-gray-800">{{ $skpp->created_at->format('d F Y, H:i') }}</p>
        </div>
    </div>

    @if ($skpp->status == 'pending')
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Tindakan</h2>
            <div class="flex gap-4">
                <form action="{{ route('admin.skpp.approve', $skpp) }}" method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin menyetujui SKPP ini?')">
                    @csrf
                    <button type="submit"
                        class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                        ✓ Setujui SKPP
                    </button>
                </form>

                <button onclick="showRejectModal()"
                    class="bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition">
                    ✗ Tolak SKPP
                </button>
            </div>
        </div>
    @endif

    @if ($skpp->status == 'ditolak' && $skpp->alasan_penolakan)
        <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded mb-6">
            <h3 class="font-bold text-red-800 mb-2">Alasan Penolakan:</h3>
            <p class="text-red-700">{{ $skpp->alasan_penolakan }}</p>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow p-6 mb-6">
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
                <p class="font-semibold text-gray-800">{{ $skpp->tanggal_lahir->format('d F Y') }}</p>
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

    <div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Tolak SKPP</h3>
            <form action="{{ route('admin.skpp.reject', $skpp) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan <span
                            class="text-red-500">*</span></label>
                    <textarea name="alasan_penolakan" rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500"
                        placeholder="Masukkan alasan penolakan (minimal 10 karakter)" required></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="closeRejectModal()"
                        class="flex-1 bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                        Tolak SKPP
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showRejectModal() {
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
    </script>
@endsection
