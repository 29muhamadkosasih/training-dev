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
        Schema::create('supply_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('supply_id')->nullable();
            $table->string('nama_peralatan')->nullable();
            $table->text('spesifikasi')->nullable();
            $table->string('satuan')->nullable();
            $table->integer('jumlah')->default(1);
            $table->integer('number')->nullable();
            // Foreign keys
            $table->foreign('supply_id')->references('id')->on('supplys')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supply_details');
    }
};
