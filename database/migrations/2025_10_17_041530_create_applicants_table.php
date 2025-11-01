<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('bukti_pembayaran')->nullable();
            $table->string('nisn');
            $table->string('nama_lengkap');
            $table->date('tanggal_lahir');
            $table->text('alamat');
            $table->string('nomor_telepon');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('asal_sekolah');
            $table->foreignId('major_id')->nullable()->constrained('majors');
            $table->string('pekerjaan_ayah');
            $table->string('pekerjaan_ibu');
            $table->string('nomor_telepon_wali');
            $table->foreignId('admission_path_id')->nullable()->constrained('admission_paths');
            $table->enum('status_pendaftaran', ['menunggu', 'diverifikasi', 'ditolak', 'diterima'])->default('menunggu');
            $table->foreignId('id_registration_wave')->constrained('registration_wave');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('applicants');
    }
};
