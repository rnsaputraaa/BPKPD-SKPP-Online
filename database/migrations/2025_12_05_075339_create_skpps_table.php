<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skpp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('nomor_urut');
            $table->string('kode_wilayah')->default('432.402');
            $table->enum('tipe', ['pensiun', 'meninggal_dunia', 'mutasi']);
            $table->string('tahun_surat');
            $table->date('tanggal_surat');

            // Data Pegawai
            $table->string('nip');
            $table->string('nama');
            $table->date('tanggal_lahir');
            $table->string('golongan');
            $table->string('jabatan');
            $table->string('unit_kerja');

            // Data SK
            $table->string('sk_dari');
            $table->string('sk_nomor');
            $table->date('sk_tanggal');
            $table->date('tanggal_mulai')->nullable();

            // Khusus untuk tipe
            $table->decimal('pensiun_pokok', 15, 2)->nullable();
            $table->date('tanggal_kematian')->nullable();
            $table->string('pindah_ke')->nullable();

            // Gaji
            $table->string('gaji_sampai_bulan');

            // Penerimaan
            $table->decimal('gaji_pokok', 15, 2)->default(0);
            $table->decimal('tun_pasangan', 15, 2)->default(0);
            $table->decimal('tun_anak', 15, 2)->default(0);
            $table->decimal('tun_pp', 15, 2)->default(0);
            $table->decimal('tun_struktural', 15, 2)->default(0);
            $table->decimal('tun_fungsional', 15, 2)->default(0);
            $table->decimal('tun_beras', 15, 2)->default(0);
            $table->decimal('tun_umum', 15, 2)->default(0);
            $table->decimal('tun_fk', 15, 2)->default(0);
            $table->decimal('tun_mahal', 15, 2)->default(0);
            $table->decimal('tun_terpencil', 15, 2)->default(0);
            $table->decimal('tun_bpjs', 15, 2)->default(0);
            $table->decimal('tun_pajak', 15, 2)->default(0);
            $table->decimal('tun_jkk', 15, 2)->default(0);
            $table->decimal('tun_jkm', 15, 2)->default(0);
            $table->decimal('tun_tapera', 15, 2)->default(0);
            $table->decimal('pembulatan', 15, 2)->default(0);

            // Potongan
            $table->decimal('iwp_1', 15, 2)->default(0);
            $table->decimal('iwp_8', 15, 2)->default(0);
            $table->decimal('pot_bpjs', 15, 2)->default(0);
            $table->decimal('pot_pajak', 15, 2)->default(0);
            $table->decimal('pot_bulog', 15, 2)->default(0);
            $table->decimal('pot_taperum', 15, 2)->default(0);
            $table->decimal('iuran', 15, 2)->default(0);
            $table->decimal('pot_sewa', 15, 2)->default(0);
            $table->decimal('pot_hutang', 15, 2)->default(0);
            $table->decimal('pot_jkk', 15, 2)->default(0);
            $table->decimal('pot_jkm', 15, 2)->default(0);
            $table->decimal('pot_tapera', 15, 2)->default(0);
            $table->decimal('pot_tapera_peg', 15, 2)->default(0);

            // Total
            $table->decimal('jumlah_kotor', 15, 2);
            $table->decimal('jumlah_pot', 15, 2);
            $table->decimal('jumlah_bersih', 15, 2);

            // Keluarga (JSON)
            $table->json('keluarga')->nullable();

            // Hutang
            $table->decimal('jum_hut', 15, 2)->default(0);
            $table->text('ket_hut')->nullable();

            $table->enum('status', ['diproses', 'disetujui', 'ditolak'])->default('diproses');
            $table->text('alasan_penolakan')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skpp');
    }
};
