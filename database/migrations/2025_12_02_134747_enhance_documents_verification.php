// database/migrations/2025_12_02_000001_enhance_documents_verification.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->json('verification_status')->nullable()->after('status_verifikasi');
            $table->json('verification_notes')->nullable()->after('verification_status');
        });

        DB::statement("ALTER TABLE documents MODIFY COLUMN status_verifikasi ENUM(
            'menunggu',
            'sedang_diverifikasi',
            'perlu_perbaikan',
            'lengkap'
        ) DEFAULT 'menunggu'");

        DB::table('documents')->update([
            'verification_status' => json_encode([]),
            'verification_notes'  => json_encode([])
        ]);
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn(['verification_status', 'verification_notes']);
        });

        DB::statement("ALTER TABLE documents MODIFY COLUMN status_verifikasi ENUM('menunggu', 'ditolak', 'diterima') DEFAULT 'menunggu'");
    }
};
