<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pastikan semua data valid sebelum ubah ke ENUM
        DB::table('applicants')
            ->whereNotIn('status_verifikasi', ['menunggu', 'ditolak', 'diterima'])
            ->orWhereNull('status_verifikasi')
            ->update(['status_verifikasi' => 'menunggu']);

        // Ubah tipe kolom ke ENUM
        DB::statement("ALTER TABLE applicants MODIFY status_verifikasi ENUM('menunggu', 'ditolak', 'diterima') NOT NULL DEFAULT 'menunggu'");
    }

    public function down(): void
    {
        // Rollback ke stringccccccccccc
        DB::statement("ALTER TABLE applicants MODIFY status_verifikasi VARCHAR(255) NULL DEFAULT 'menunggu'");
    }
};
