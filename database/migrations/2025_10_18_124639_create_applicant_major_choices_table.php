<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('applicant_major_choices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id')->constrained('applicants')->onDelete('cascade');
            $table->foreignId('major_id')->constrained('majors')->onDelete('cascade');
            $table->unsignedTinyInteger('priority')->comment('1 = pilihan utama, 2 = cadangan pertama, 3 = cadangan kedua, dst...');
            $table->timestamps();

            $table->unique(['applicant_id', 'major_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('applicant_major_choices');
    }
};
