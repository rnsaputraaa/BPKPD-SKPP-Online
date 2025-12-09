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
        $totalPending = Skpp::where('status', 'pending')->count();
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
            'totalPending',
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

        $skpps = $query->paginate(15)->withQueryString();

        return view('admin.skpp.index', compact('skpps'));
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

    public function print(Skpp $skpp)
    {
        if ($skpp->status !== 'disetujui') {
            return redirect()
                ->route('admin.skpp.show', $skpp)
                ->with('error', 'SKPP harus disetujui terlebih dahulu sebelum dapat dicetak!');
        }

        try {
            $templateFile = match ($skpp->tipe) {
                'pensiun' => storage_path('app/templates/TEMPLATE SKPP PENSIUN.docx'),
                'meninggal_dunia' => storage_path('app/templates/TEMPLATE SKPP MD.docx'),
                'mutasi' => storage_path('app/templates/TEMPLATE SKPP MUTASI.docx'),
                default => null,
            };

            if (!$templateFile) {
                throw new \Exception('Tipe SKPP tidak valid: ' . $skpp->tipe);
            }

            if (!file_exists($templateFile)) {
                throw new \Exception('Template file tidak ditemukan. Pastikan file template ada di: ' . $templateFile);
            }

            if (!class_exists('PhpOffice\PhpWord\TemplateProcessor')) {
                throw new \Exception('PhpWord library tidak terinstall. Jalankan: composer require phpoffice/phpword');
            }

            $template = new TemplateProcessor($templateFile);

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

            $fileName = "SKPP_" . preg_replace('/[^A-Za-z0-9_\-]/', '_', $skpp->nama) . "_{$skpp->nomor_urut}_" . time() . ".docx";
            $filePath = storage_path("app/public/{$fileName}");

            $directory = storage_path('app/public');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            $template->saveAs($filePath);

            if (!file_exists($filePath)) {
                throw new \Exception('Gagal membuat file DOCX. Periksa permission folder storage/app/public');
            }

            return response()->download($filePath, $fileName)->deleteFileAfterSend(true);
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
