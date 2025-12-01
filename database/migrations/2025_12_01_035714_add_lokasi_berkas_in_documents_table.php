<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {


            if (!Schema::hasColumn('documents', 'status_verifikasi')) {
                $table->enum('status_verifikasi', ['menunggu', 'diterima', 'ditolak'])
                      ->default('menunggu')
                      ->after('lokasi_berkas');
            }

            $table->string('kartu_keluarga')->nullable()->change();
            $table->string('akte_kelahiran')->nullable()->change();
            $table->string('ijazah')->nullable()->change();
            $table->string('surat_kelulusan')->nullable()->change();
            $table->string('ktp_ayah')->nullable()->change();
            $table->string('ktp_ibu')->nullable()->change();
            $table->string('surat_kesehatan')->nullable()->change();
            $table->string('lokasi_berkas')->nullable()->after('surat_kesehatan')->change();
        });
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('lokasi_berkas');

            if (Schema::hasColumn('documents', 'status_verifikasi')) {
                $table->dropColumn('status_verifikasi');
            }
        });
    }
};
