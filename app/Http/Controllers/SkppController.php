<?php

namespace App\Http\Controllers;

use App\Models\Skpp;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;
use Carbon\Carbon;

class SkppController extends Controller
{
    public function dashboard()
    {
        $skpps = Skpp::where('user_id', request()->user()->id)->latest()->get();
        return view('dashboard', compact('skpps'));
    }

    public function index()
    {
        $skpps = Skpp::where('user_id', request()->user()->id)->latest()->get();
        return view('skpp.index', compact('skpps'));
    }

    public function create()
    {
        return view('skpp.create');
    }

    public function store(Request $request)
    {
        if (!$request->tipe) {
            return redirect()->back()
                ->withErrors(['tipe' => 'Pilih tipe SKPP terlebih dahulu.'])
                ->withInput();
        }

        $validated = $request->validate([
            'tipe' => 'required|in:pensiun,meninggal_dunia,mutasi',
            'nip' => 'required',
            'nama' => 'required',
            'tanggal_lahir' => 'required|date',
            'golongan' => 'required',
            'jabatan' => 'required',
            'unit_kerja' => 'required',
            'sk_dari' => 'required',
            'sk_nomor' => 'required',
            'sk_tanggal' => 'required|date',
            'gaji_sampai_bulan' => 'required',
        ]);

        $penerimaan = [
            'gaji_pokok',
            'tun_pasangan',
            'tun_anak',
            'tun_pp',
            'tun_struktural',
            'tun_fungsional',
            'tun_beras',
            'tun_umum',
            'tun_fk',
            'tun_mahal',
            'tun_terpencil',
            'tun_bpjs',
            'tun_pajak',
            'tun_jkk',
            'tun_jkm',
            'tun_tapera',
            'pembulatan'
        ];

        $potongan = [
            'iwp_1',
            'iwp_8',
            'pot_bpjs',
            'pot_pajak',
            'pot_bulog',
            'pot_taperum',
            'iuran',
            'pot_sewa',
            'pot_hutang',
            'pot_jkk',
            'pot_jkm',
            'pot_tapera',
            'pot_tapera_peg'
        ];

        $jumlah_kotor = 0;
        foreach ($penerimaan as $field) {
            $jumlah_kotor += floatval($request->input($field, 0));
        }

        $jumlah_pot = 0;
        foreach ($potongan as $field) {
            $jumlah_pot += floatval($request->input($field, 0));
        }

        $jumlah_bersih = $jumlah_kotor - $jumlah_pot;

        $keluarga = [];
        for ($i = 1; $i <= 5; $i++) {
            if ($request->input("nama_keluarga{$i}")) {
                $keluarga[] = [
                    'nama' => $request->input("nama_keluarga{$i}"),
                    'tanggal_lahir' => $request->input("lahir{$i}"),
                    'keterangan' => $request->input("ket{$i}"),
                ];
            }
        }

        $year = date('Y');
        $nomor_urut = Skpp::getNextNomorUrut($year);

        $data = array_merge($request->all(), [
            'user_id' => request()->user()->id,
            'nomor_urut' => $nomor_urut,
            'tahun_surat' => $year,
            'tanggal_surat' => now(),
            'jumlah_kotor' => $jumlah_kotor,
            'jumlah_pot' => $jumlah_pot,
            'jumlah_bersih' => $jumlah_bersih,
            'keluarga' => $keluarga,
            'jum_hut' => $request->jum_hut ?? 0,
            'ket_hut' => $request->ket_hut ?? '',
            'status' => 'diproses',
        ]);

        foreach (array_merge($penerimaan, $potongan) as $field) {
            if (!isset($data[$field]) || $data[$field] === '') {
                $data[$field] = 0;
            }
        }

        $skpp = Skpp::create($data);

        return redirect()->route('skpp.show', $skpp)->with('success', 'SKPP berhasil diajukan!');
    }

    public function show(Skpp $skpp)
    {
        if ($skpp->user_id != request()->user()->id) {
            abort(403);
        }

        return view('skpp.show', compact('skpp'));
    }

    public function print(Skpp $skpp)
    {
        if ($skpp->user_id != request()->user()->id) {
            abort(403);
        }

        if ($skpp->status === 'diproses') {
            $skpp->update(['status' => 'disetujui']);
        }

        $templateFile = match ($skpp->tipe) {
            'pensiun' => storage_path('app/templates/TEMPLATE SKPP PENSIUN.docx'),
            'meninggal_dunia' => storage_path('app/templates/TEMPLATE SKPP MD.docx'),
            'mutasi' => storage_path('app/templates/TEMPLATE SKPP MUTASI.docx'),
        };

        $template = new TemplateProcessor($templateFile);

        $template->setValue('nomor_urut', str_pad($skpp->nomor_urut, 3, '0', STR_PAD_LEFT));
        $template->setValue('kode_wilayah', $skpp->kode_wilayah);
        $template->setValue('tahun_surat', $skpp->tahun_surat);
        $template->setValue('nip', $skpp->nip);
        $template->setValue('nama', $skpp->nama);
        $template->setValue('taggal_lahir', $skpp->tanggal_lahir->locale('id')->translatedFormat('d F Y'));
        $template->setValue('golongan', $skpp->golongan);
        $template->setValue('jabatan', $skpp->jabatan);
        $template->setValue('unit_kerja', $skpp->unit_kerja);
        $template->setValue('sk_dari', strtoupper($skpp->sk_dari));
        $template->setValue('sk_nomor', $skpp->sk_nomor);
        $template->setValue('sk_tanggal', Carbon::parse($skpp->sk_tanggal)->locale('id')->translatedFormat('d F Y'));

        if ($skpp->tipe === 'pensiun') {
            $template->setValue('tanggal_mulai', $skpp->tanggal_mulai ? Carbon::parse($skpp->tanggal_mulai)->locale('id')->translatedFormat('d F Y') : '-');
            $template->setValue('pensiun_pokok', number_format($skpp->pensiun_pokok, 0, ',', '.'));
        } elseif ($skpp->tipe === 'meninggal_dunia') {
            $template->setValue('tanggal_kematian', $skpp->tanggal_kematian ? Carbon::parse($skpp->tanggal_kematian)->locale('id')->translatedFormat('d F Y') : '-');
        } elseif ($skpp->tipe === 'mutasi') {
            $template->setValue('tanggal_mulai', $skpp->tanggal_mulai ? Carbon::parse($skpp->tanggal_mulai)->locale('id')->translatedFormat('d F Y') : '-');
            $template->setValue('pindah_ke', $skpp->pindah_ke);
        }

        $template->setValue('gaji_sampai_bulan', strtoupper($skpp->gaji_sampai_bulan));

        $fields = [
            'gaji_pokok',
            'tun_pasangan',
            'tun_anak',
            'tun_pp',
            'tun_struktural',
            'tun_fungsional',
            'tun_beras',
            'tun_umum',
            'tun_fk',
            'tun_mahal',
            'tun_terpencil',
            'tun_bpjs',
            'tun_pajak',
            'tun_jkk',
            'tun_jkm',
            'tun_tapera',
            'pembulatan',
            'iwp_1',
            'iwp_8',
            'pot_bpjs',
            'pot_pajak',
            'pot_bulog',
            'pot_taperum',
            'iuran',
            'pot_sewa',
            'pot_hutang',
            'pot_jkk',
            'pot_jkm',
            'pot_tapera',
            'pot_tapera_peg'
        ];

        foreach ($fields as $field) {
            $template->setValue($field, number_format($skpp->$field, 0, ',', '.'));
        }

        $template->setValue('jumlah_kotor', number_format($skpp->jumlah_kotor, 0, ',', '.'));
        $template->setValue('jumlah_pot', number_format($skpp->jumlah_pot, 0, ',', '.'));
        $template->setValue('jumlah_bersih', number_format($skpp->jumlah_bersih, 0, ',', '.'));

        for ($i = 1; $i <= 5; $i++) {
            if (isset($skpp->keluarga[$i - 1])) {
                $keluarga = $skpp->keluarga[$i - 1];
                $template->setValue("nama_keluarga{$i}", $keluarga['nama']);
                $template->setValue("lahir{$i}", $keluarga['tanggal_lahir']);
                $template->setValue("ket{$i}", $keluarga['keterangan']);
            } else {
                $template->setValue("nama_keluarga{$i}", '');
                $template->setValue("lahir{$i}", '');
                $template->setValue("ket{$i}", '');
            }
        }

        $template->setValue('jum_hut', $skpp->jum_hut ? number_format($skpp->jum_hut, 0, ',', '.') : '0');
        $template->setValue('ket_hut', $skpp->ket_hut ?? '');

        $template->setValue('tanggal_surat', Carbon::parse($skpp->tanggal_surat)->isoFormat('D MMMM Y'));

        $fileName = "SKPP_{$skpp->nama}_{$skpp->nomor_urut}.docx";
        $template->saveAs(storage_path("app/public/{$fileName}"));

        return response()->download(storage_path("app/public/{$fileName}"))->deleteFileAfterSend();
    }
}
