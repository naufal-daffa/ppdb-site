<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
// migration file
public function up()
{
    Schema::table('documents', function (Blueprint $table) {
        $table->enum('status_verifikasi', ['menunggu', 'diverifikasi', 'ditolak', 'lengkap'])
              ->default('menunggu')
              ->after('surat_kesehatan');
    });
}

public function down()
{
    Schema::table('documents', function (Blueprint $table) {
        $table->dropColumn('status_verifikasi');
    });
}
};
