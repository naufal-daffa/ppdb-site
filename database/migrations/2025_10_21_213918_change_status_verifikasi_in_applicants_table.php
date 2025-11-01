<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->enum('status_verifikasi', ['menunggu', 'ditolak', 'diterima'])->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('applicants')
            ->whereNotIn('status_verifikasi', ['menunggu', 'ditolak', 'diterima'])
            ->orWhereNull('status_verifikasi')
            ->update(['status_verifikasi' => 'menunggu']);

        // Ubah tipe kolom ke ENUM
        DB::statement("ALTER TABLE applicants MODIFY status_verifikasi ENUM('menunggu', 'ditolak', 'diterima') NOT NULL DEFAULT 'menunggu'");
    }
};
