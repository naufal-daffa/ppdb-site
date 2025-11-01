<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id')->constrained('applicants');
            $table->string('kartu_keluarga');
            $table->string('akte_kelahiran');
            $table->string('ijazah');
            $table->string('surat_kelulusan');
            $table->string('lokasi_berkas');
            $table->string('ktp_ayah');
            $table->string('ktp_ibu');
            $table->string('surat_kesehatan');
            $table->enum('status_verifikasi', ['menunggu', 'ditolak', 'diterima'])->default('menunggu');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('documents');
    }
};

