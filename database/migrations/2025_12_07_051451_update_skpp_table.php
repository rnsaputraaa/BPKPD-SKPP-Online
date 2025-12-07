<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('skpp', function (Blueprint $table) {
            if (Schema::hasColumn('skpp', 'ttd_pengirim')) {
                $table->dropColumn('ttd_pengirim');
            }

            DB::statement("ALTER TABLE skpp MODIFY COLUMN status ENUM('diproses', 'disetujui', 'ditolak') DEFAULT 'diproses'");

            if (!Schema::hasColumn('skpp', 'alasan_penolakan')) {
                $table->text('alasan_penolakan')->nullable()->after('status');
            }

            if (!Schema::hasColumn('skpp', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('alasan_penolakan');
            }

            if (!Schema::hasColumn('skpp', 'approved_by')) {
                $table->foreignId('approved_by')->nullable()->constrained('users')->after('approved_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('skpp', function (Blueprint $table) {
            $table->dropColumn(['alasan_penolakan', 'approved_at', 'approved_by']);
            $table->string('ttd_pengirim')->default('');
            DB::statement("ALTER TABLE skpp MODIFY COLUMN status ENUM('diproses', 'disetujui') DEFAULT 'diproses'");
        });
    }
};
