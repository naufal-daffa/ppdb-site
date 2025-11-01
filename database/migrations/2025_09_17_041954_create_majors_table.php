<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('majors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skill_field_id')->constrained('skill_fields');
            $table->string('nama');
            $table->text('deskripsi');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('majors');
    }
};
