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
        Schema::create('curricula', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('document_id');
            $table->enum('kelompok', ['inti', 'penunjang', 'ojt'])->default('inti');
            $table->integer('urutan')->nullable();
            $table->uuid('competence_code_id')->nullable();
            $table->integer('perkiraan_waktu_teori')->default(0);
            $table->integer('perkiraan_waktu_praktek')->default(0);
            $table->integer('jumlah')->default(0);
            $table->string('ojt_bulan')->nullable();
            $table->timestamps();

            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
            $table->index('kelompok');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curricula');
    }
};
