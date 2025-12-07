<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Skpp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpWord\TemplateProcessor;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('nip', $credentials['username'])
            ->where('role', 'admin')
            ->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah, atau Anda bukan admin.',
        ])->onlyInput('username');
    }

    public function dashboard()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalSkpp = Skpp::count();
        $totalDiproses = Skpp::where('status', 'diproses')->count();
        $totalDisetujui = Skpp::where('status', 'disetujui')->count();
        $totalDitolak = Skpp::where('status', 'ditolak')->count();

        $recentSkpp = Skpp::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalSkpp',
            'totalDiproses',
            'totalDisetujui',
            'totalDitolak',
            'recentSkpp'
        ));
    }

    public function skppList()
    {
        $skpps = Skpp::with('user')->latest()->get();
        return view('admin.skpp.index', compact('skpps'));
    }

    public function skppShow(Skpp $skpp)
    {
        $skpp->load('user');
        return view('admin.skpp.show', compact('skpp'));
    }

    public function approve(Skpp $skpp)
    {
        $skpp->update([
            'status' => 'disetujui',
            'approved_at' => now(),
            'approved_by' => Auth::id(),
            'alasan_penolakan' => null,
        ]);

        return redirect()
            ->route('admin.skpp.show', $skpp)
            ->with('success', 'SKPP berhasil disetujui!');
    }

    public function reject(Request $request, Skpp $skpp)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string|min:10',
        ], [
            'alasan_penolakan.required' => 'Alasan penolakan wajib diisi',
            'alasan_penolakan.min' => 'Alasan penolakan minimal 10 karakter',
        ]);

        $skpp->update([
            'status' => 'ditolak',
            'approved_at' => now(),
            'approved_by' => Auth::id(),
            'alasan_penolakan' => $request->alasan_penolakan,
        ]);

        return redirect()
            ->route('admin.skpp.show', $skpp)
            ->with('success', 'SKPP telah ditolak!');
    }

    public function print(Skpp $skpp)
    {
        if ($skpp->status !== 'disetujui') {
            return redirect()
                ->route('admin.skpp.show', $skpp)
                ->with('error', 'SKPP harus disetujui terlebih dahulu sebelum dapat dicetak!');
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
        $template->setValue('taggal_lahir', $skpp->tanggal_lahir->format('d-m-Y'));
        $template->setValue('golongan', $skpp->golongan);
        $template->setValue('jabatan', $skpp->jabatan);
        $template->setValue('unit_kerja', $skpp->unit_kerja);
        $template->setValue('sk_dari', $skpp->sk_dari);
        $template->setValue('sk_nomor', $skpp->sk_nomor);
        $template->setValue('sk_tanggal', Carbon::parse($skpp->sk_tanggal)->format('d-m-Y'));

        if ($skpp->tipe === 'pensiun') {
            $template->setValue('tanggal_mulai', $skpp->tanggal_mulai ? Carbon::parse($skpp->tanggal_mulai)->format('d-m-Y') : '-');
            $template->setValue('pensiun_pokok', number_format($skpp->pensiun_pokok, 0, ',', '.'));
        } elseif ($skpp->tipe === 'meninggal_dunia') {
            $template->setValue('tanggal_kematian', $skpp->tanggal_kematian ? Carbon::parse($skpp->tanggal_kematian)->format('d-m-Y') : '-');
        } elseif ($skpp->tipe === 'mutasi') {
            $template->setValue('tanggal_mulai', $skpp->tanggal_mulai ? Carbon::parse($skpp->tanggal_mulai)->format('d-m-Y') : '-');
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
                $kel = $skpp->keluarga[$i - 1];
                $template->setValue("nama_keluarga{$i}", $kel['nama']);
                $template->setValue("lahir{$i}", $kel['tanggal_lahir']);
                $template->setValue("ket{$i}", $kel['keterangan']);
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

        return response()
            ->download(storage_path("app/public/{$fileName}"))
            ->deleteFileAfterSend();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
