<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('silabus_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('silabus_id');
            $table->uuid('element_id')->nullable();
            $table->longText('indikator')->nullable();
            $table->longText('pengetahuan')->nullable();
            $table->longText('keterampilan_sikap')->nullable();
            $table->string('durasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('silabus_details');
    }
};
