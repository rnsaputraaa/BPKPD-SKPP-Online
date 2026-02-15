<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Skpp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpWord\TemplateProcessor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    public function showLogin()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
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

            return redirect()->route('admin.dashboard');
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

        $skppByType = Skpp::select('tipe', DB::raw('count(*) as total'))
            ->groupBy('tipe')
            ->get()
            ->pluck('total', 'tipe');

        $recentSkpp = Skpp::with('user')
            ->latest()
            ->take(3)
            ->get();

        $monthlyStats = Skpp::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('count(*) as total')
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalSkpp',
            'totalDiproses',
            'totalDisetujui',
            'totalDitolak',
            'recentSkpp',
            'skppByType',
            'monthlyStats'
        ));
    }

    public function skppList(Request $request)
    {
        $query = Skpp::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);

            $keywords = explode(' ', $search);

            $query->where(function ($q) use ($keywords) {
                foreach ($keywords as $word) {
                    $q->where(function ($sub) use ($word) {
                        if (ctype_digit($word)) {
                            $sub->where('nomor_urut', intval($word));
                        }

                        $sub->orWhere('nama', 'like', "%{$word}%")
                            ->orWhere('nip', 'like', "%{$word}%");

                        $sub->orWhereHas('user', function ($u) use ($word) {
                            $u->where('nama', 'like', "%{$word}%")
                                ->orWhere('nip', 'like', "%{$word}%");
                        });
                    });
                }
            });
        }

        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $skpps = $query->paginate(10)->withQueryString();

        return view('admin.skpp.index', compact('skpps'));
    }

    public function pegawaiList(Request $request)
    {
        $pegawai = User::where('role', 'user')
            ->withCount('skpp')
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('nama', 'like', '%' . $request->search . '%')
                        ->orWhere('nip', 'like', '%' . $request->search . '%');
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.pegawai.index', compact('pegawai'));
    }

    public function createPegawai()
    {
        return view('admin.pegawai.create');
    }

    public function storePegawai(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|unique:users,nip|max:50',
            'password' => ['required', Password::min(6)],
        ], [
            'nama.required' => 'Nama wajib diisi',
            'nip.required' => 'NIP wajib diisi',
            'nip.unique' => 'NIP sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        User::create([
            'nama' => $validated['nama'],
            'nip' => $validated['nip'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);

        return redirect()->route('admin.pegawai.index')
            ->with('success', 'Data pegawai berhasil ditambahkan');
    }

    public function editPegawai(User $pegawai)
    {
        if ($pegawai->role === 'admin') {
            return redirect()->route('admin.pegawai.index')
                ->with('error', 'Tidak dapat mengedit data admin');
        }

        return view('admin.pegawai.edit', compact('pegawai'));
    }

    public function updatePegawai(Request $request, User $pegawai)
    {
        if ($pegawai->role === 'admin') {
            return redirect()->route('admin.pegawai.index')
                ->with('error', 'Tidak dapat mengubah data admin');
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:50|unique:users,nip,' . $pegawai->id,
            'password' => ['nullable', Password::min(6)],
        ], [
            'nama.required' => 'Nama wajib diisi',
            'nip.required' => 'NIP wajib diisi',
            'nip.unique' => 'NIP sudah terdaftar',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        $pegawai->nama = $validated['nama'];
        $pegawai->nip = $validated['nip'];

        if ($request->filled('password')) {
            $pegawai->password = Hash::make($request->password);
        }

        $pegawai->save();

        return redirect()->route('admin.pegawai.index')
            ->with('success', 'Data pegawai berhasil diperbarui');
    }

    public function destroyPegawai(User $pegawai)
    {
        if ($pegawai->role === 'admin') {
            return back()->with('error', 'Tidak dapat menghapus data admin');
        }

        $pegawai->delete();
        return back()->with('success', 'Data pegawai berhasil dihapus');
    }

    public function skppShow(Skpp $skpp)
    {
        $skpp->load('user');

        if ($skpp->approved_by) {
            try {
                $skpp->load('approver');
            } catch (\Exception $e) {
                Log::warning('Approver not found for SKPP: ' . $skpp->id);
            }
        }

        return view('admin.skpp.show', compact('skpp'));
    }

    public function approve(Skpp $skpp)
    {
        if ($skpp->status === 'disetujui') {
            return redirect()
                ->route('admin.skpp.show', $skpp)
                ->with('warning', 'SKPP sudah disetujui sebelumnya!');
        }

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
        $validated = $request->validate([
            'alasan_penolakan' => 'required|string',
        ], [
            'alasan_penolakan.required' => 'Alasan penolakan wajib diisi',
        ]);

        if ($skpp->status === 'ditolak') {
            return redirect()
                ->route('admin.skpp.show', $skpp)
                ->with('warning', 'SKPP sudah ditolak sebelumnya!');
        }

        try {
            $skpp->update([
                'status' => 'ditolak',
                'approved_at' => now(),
                'approved_by' => Auth::id(),
                'alasan_penolakan' => $validated['alasan_penolakan'],
            ]);

            return redirect()
                ->route('admin.skpp.show', $skpp)
                ->with('success', 'SKPP telah ditolak!');
        } catch (\Exception $e) {
            Log::error('Error rejecting SKPP: ' . $e->getMessage());
            return redirect()
                ->route('admin.skpp.show', $skpp)
                ->with('error', 'Gagal menolak SKPP: ' . $e->getMessage());
        }
    }

    public function previewSkpp(Skpp $skpp)
    {
        try {
            $pdfPath = $this->generateSkppPdf($skpp, true);

            if (!file_exists($pdfPath)) {
                throw new \Exception('File PDF tidak ditemukan');
            }

            return response()->file($pdfPath, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="Preview_SKPP_' . $skpp->nama . '.pdf"'
            ]);
        } catch (\Exception $e) {
            Log::error('Error previewing SKPP: ' . $e->getMessage(), [
                'skpp_id' => $skpp->id,
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->route('admin.skpp.show', $skpp)
                ->with('error', 'Gagal membuat preview SKPP: ' . $e->getMessage());
        }
    }

    public function print(Skpp $skpp)
    {
        if ($skpp->status !== 'disetujui') {
            return redirect()
                ->route('admin.skpp.show', $skpp)
                ->with('error', 'SKPP harus disetujui terlebih dahulu sebelum dapat dicetak!');
        }

        try {
            $pdfPath = $this->generateSkppPdf($skpp);

            return response()->download($pdfPath, 'SKPP_' . $skpp->nama . '.pdf')
                ->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            Log::error('Error printing SKPP: ' . $e->getMessage(), [
                'skpp_id' => $skpp->id,
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->route('admin.skpp.show', $skpp)
                ->with('error', 'Gagal mencetak SKPP: ' . $e->getMessage());
        }
    }

    private function generateSkppPdf(Skpp $skpp, $isPreview = false)
    {
        $templateFile = match ($skpp->tipe) {
            'pensiun' => storage_path('app/templates/TEMPLATE SKPP PENSIUN.docx'),
            'meninggal_dunia' => storage_path('app/templates/TEMPLATE SKPP MD.docx'),
            'mutasi' => storage_path('app/templates/TEMPLATE SKPP MUTASI.docx'),
            default => null,
        };

        if (!$templateFile || !file_exists($templateFile)) {
            throw new \Exception('Template file tidak ditemukan: ' . $templateFile);
        }

        $template = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);

        $template->setValue('nomor_urut', str_pad($skpp->nomor_urut, 3, '0', STR_PAD_LEFT));
        $template->setValue('kode_wilayah', $skpp->kode_wilayah ?? '');
        $template->setValue('tahun_surat', $skpp->tahun_surat ?? '');
        $template->setValue('nip', $skpp->nip ?? '');
        $template->setValue('nama', $skpp->nama ?? '');
        $template->setValue('taggal_lahir', $skpp->tanggal_lahir ? $skpp->tanggal_lahir->format('d-m-Y') : '-');

        $template->setValue('golongan', $skpp->golongan ?? '');
        $template->setValue('jabatan', $skpp->jabatan ?? '');
        $template->setValue('unit_kerja', $skpp->unit_kerja ?? '');
        $template->setValue('sk_dari', $skpp->sk_dari ?? '');
        $template->setValue('sk_nomor', $skpp->sk_nomor ?? '');
        $template->setValue('sk_tanggal', $skpp->sk_tanggal ? Carbon::parse($skpp->sk_tanggal)->format('d-m-Y') : '-');

        if ($skpp->tipe === 'pensiun') {
            $template->setValue('tanggal_mulai', $skpp->tanggal_mulai ? Carbon::parse($skpp->tanggal_mulai)->format('d-m-Y') : '-');
            $template->setValue('pensiun_pokok', number_format($skpp->pensiun_pokok ?? 0, 0, ',', '.'));
        } elseif ($skpp->tipe === 'meninggal_dunia') {
            $template->setValue('tanggal_kematian', $skpp->tanggal_kematian ? Carbon::parse($skpp->tanggal_kematian)->format('d-m-Y') : '-');
        } elseif ($skpp->tipe === 'mutasi') {
            $template->setValue('tanggal_mulai', $skpp->tanggal_mulai ? Carbon::parse($skpp->tanggal_mulai)->format('d-m-Y') : '-');
            $template->setValue('pindah_ke', $skpp->pindah_ke ?? '-');
        }

        $template->setValue('gaji_sampai_bulan', strtoupper($skpp->gaji_sampai_bulan ?? ''));

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
            $value = $skpp->$field ?? 0;
            $template->setValue($field, number_format($value, 0, ',', '.'));
        }

        $template->setValue('jumlah_kotor', number_format($skpp->jumlah_kotor ?? 0, 0, ',', '.'));
        $template->setValue('jumlah_pot', number_format($skpp->jumlah_pot ?? 0, 0, ',', '.'));
        $template->setValue('jumlah_bersih', number_format($skpp->jumlah_bersih ?? 0, 0, ',', '.'));

        for ($i = 1; $i <= 5; $i++) {
            if (isset($skpp->keluarga[$i - 1])) {
                $kel = $skpp->keluarga[$i - 1];
                $template->setValue("nama_keluarga{$i}", $kel['nama'] ?? '');
                $template->setValue("lahir{$i}", $kel['tanggal_lahir'] ?? '');
                $template->setValue("ket{$i}", $kel['keterangan'] ?? '');
            } else {
                $template->setValue("nama_keluarga{$i}", '');
                $template->setValue("lahir{$i}", '');
                $template->setValue("ket{$i}", '');
            }
        }

        $template->setValue('jum_hut', $skpp->jum_hut ? number_format($skpp->jum_hut, 0, ',', '.') : '0');
        $template->setValue('ket_hut', $skpp->ket_hut ?? '');
        $template->setValue('tanggal_surat', $skpp->tanggal_surat ? Carbon::parse($skpp->tanggal_surat)->isoFormat('D MMMM Y') : '-');

        $prefix = $isPreview ? 'preview_' : 'skpp_';
        $tempDocxName = $prefix . $skpp->id . '_' . time() . '.docx';
        $tempDocxPath = storage_path('app/temp/' . $tempDocxName);

        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0777, true);
        }

        $template->saveAs($tempDocxPath);

        $pdfFolder = storage_path('app/pdf');
        if (!file_exists($pdfFolder)) {
            mkdir($pdfFolder, 0777, true);
        }

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $soffice = '"C:\Program Files\LibreOffice\program\soffice.exe"';
        } else {
            $soffice = 'libreoffice';
        }

        $command = $soffice . ' --headless --convert-to pdf "' . $tempDocxPath . '" --outdir "' . $pdfFolder . '"';
        exec($command, $output, $result);

        if ($result !== 0) {
            throw new \Exception("Gagal convert PDF. Pastikan LibreOffice terinstall & PATH sudah benar.");
        }

        $pdfPath = $pdfFolder . '/' . str_replace('.docx', '.pdf', $tempDocxName);

        if (file_exists($tempDocxPath)) {
            unlink($tempDocxPath);
        }

        return $pdfPath;
    }

    public function userManagement()
    {
        $users = User::where('role', 'user')
            ->withCount('skpps')
            ->latest()
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function reports()
    {
        $statistics = [
            'total_skpp' => Skpp::count(),
            'approved_this_month' => Skpp::where('status', 'disetujui')
                ->whereMonth('approved_at', now()->month)
                ->count(),
            'pending_count' => Skpp::where('status', 'pending')->count(),
            'rejected_count' => Skpp::where('status', 'ditolak')->count(),
        ];

        return view('admin.reports', compact('statistics'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
