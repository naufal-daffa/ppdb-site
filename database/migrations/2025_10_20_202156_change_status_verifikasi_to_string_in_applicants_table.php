<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tahap 1: ubah dulu jadi VARCHAR tanpa default
        DB::statement("ALTER TABLE applicants MODIFY status_verifikasi VARCHAR(255) NULL");

        // Tahap 2: ubah default value setelah kolom berhasil diubah
        DB::statement("ALTER TABLE applicants ALTER status_verifikasi SET DEFAULT 'menunggu'");
    }


    public function down(): void
    {
        DB::statement("ALTER TABLE applicants MODIFY status_verifikasi ENUM('pending', 'approved', 'rejected') DEFAULT 'pending'");
    }
};
