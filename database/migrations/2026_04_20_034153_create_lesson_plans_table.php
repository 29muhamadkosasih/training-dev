<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lesson_plans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('document_id');
            $table->longText('persiapan_text')->nullable();
            $table->longText('media')->nullable();
            $table->longText('metode')->nullable();
            $table->longText('tujuan_instruksional')->nullable();
            $table->longText('waktu_jp')->nullable();
            $table->longText('waktu_menit')->nullable();
            $table->longText('penyajian_hari')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_plans');
    }
};
