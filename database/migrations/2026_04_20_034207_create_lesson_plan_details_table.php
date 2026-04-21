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
        Schema::create('lesson_plan_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('lesson_plan_id');
            $table->longText('sub_pokok')->nullable();
            $table->longText('uraian')->nullable();
            $table->longText('media')->nullable();
            $table->integer('waktu')->nullable();
            $table->integer('number')->nullable();
            $table->timestamps();
            $table->foreign('lesson_plan_id')->references('id')->on('lesson_plans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_plan_details');
    }
};
