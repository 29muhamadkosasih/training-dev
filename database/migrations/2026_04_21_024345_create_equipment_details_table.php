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
        Schema::create('equipment_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('equipment_id')->nullable();
            $table->string('nama_peralatan')->nullable();
            $table->text('spesifikasi')->nullable();
            $table->string('satuan')->nullable();
            $table->integer('jumlah')->default(1);
            $table->integer('number')->nullable();
            $table->timestamps();
            // Foreign keys
            $table->foreign('equipment_id')->references('id')->on('equipments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_details');
    }
};
