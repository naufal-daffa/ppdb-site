<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('staff', function (Blueprint $table) {
            // Hapus foreign key lama yang salah
            $table->dropForeign(['applicant_id']);

            // Ubah kolom agar tetap unsignedBigInteger (jika perlu)
            $table->unsignedBigInteger('applicant_id')->change();

            // Buat foreign key yang benar → ke tabel applicants
            $table->foreign('applicant_id')->references('id')->on('applicants');
        });
    }

    public function down()
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->dropForeign(['applicant_id']);
            $table->foreignId('applicant_id')->constrained('users');
        });
    }
};
