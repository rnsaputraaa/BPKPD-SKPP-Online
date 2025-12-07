<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skpp extends Model
{
    protected $table = 'skpp';

    protected $fillable = [
        'user_id',
        'nomor_urut',
        'kode_wilayah',
        'tipe',
        'tahun_surat',
        'tanggal_surat',
        'nip',
        'nama',
        'tanggal_lahir',
        'golongan',
        'jabatan',
        'unit_kerja',
        'sk_dari',
        'sk_nomor',
        'sk_tanggal',
        'tanggal_mulai',
        'pensiun_pokok',
        'tanggal_kematian',
        'pindah_ke',
        'gaji_sampai_bulan',
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
        'pot_tapera_peg',
        'jumlah_kotor',
        'jumlah_pot',
        'jumlah_bersih',
        'keluarga',
        'jum_hut',
        'ket_hut',
        'ttd_pengirim',
        'status'
    ];

    protected $casts = [
        'keluarga' => 'array',
        'tanggal_lahir' => 'date',
        'sk_tanggal' => 'date',
        'tanggal_mulai' => 'date',
        'tanggal_kematian' => 'date',
        'tanggal_surat' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getNextNomorUrut($year)
    {
        $lastSkpp = self::where('tahun_surat', $year)
            ->orderBy('nomor_urut', 'desc')
            ->first();

        return $lastSkpp ? $lastSkpp->nomor_urut + 1 : 1;
    }
}
