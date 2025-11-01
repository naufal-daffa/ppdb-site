<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('selections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id')->constrained('applicants');
            $table->string('nilai_ujian');
            $table->string('nilai_wawancara');
            $table->string('hasil_akhir');
            $table->enum('status', ['menunggu', 'lulus', 'tidak_lulus'])->default('menunggu');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('selections');
    }
};

