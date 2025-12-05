<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('applicants', function (Blueprint $table) {
            // Hapus foreign key dulu
            $table->dropForeign(['major_id']);
            // Hapus kolom
            $table->dropColumn('major_id');
        });
    }

    public function down()
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->foreignId('major_id')->nullable()->constrained('majors');
        });
    }
};
