<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropColumn('nama_file'); // hapus yang lama
            $table->string('file_path')->after('applicant_id'); // path file
            $table->string('nama_sertifikat')->after('file_path');
            $table->enum('status_verifikasi', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('catatan_staff')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropColumn(['file_path', 'nama_sertifikat', 'status_verifikasi', 'catatan_staff']);
            $table->string('nama_file');
        });
    }
};
