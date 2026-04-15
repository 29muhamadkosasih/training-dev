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
        Schema::table('general_informations', function (Blueprint $table) {
            // Kolom Dasar
            $table->string('document_id')->nullable();
    
            $table->longText('kode')->nullable();
            $table->longText('jenis_program')->nullable();
            $table->longText('metode_pelatihan')->nullable();

            // Kolom Tujuan dan Profil
            $table->longText('tujuan')->nullable();
            $table->longText('jenis_standart_kompetensi')->nullable();

            // Persyaratan Peserta Pelatihan
            $table->longText('persyaratan_pendidikan')->nullable();
            $table->longText('persyaratan_pelatihan')->nullable();
            $table->longText('persyaratan_pengalaman_kerja')->nullable();
            $table->longText('persyaratan_usia')->nullable();
            $table->longText('persyaratan_khusus_peserta')->nullable();

            // Persyaratan Instruktur
            $table->longText('instruktur_pendidikan_formal')->nullable();
            $table->longText('instruktur_kompetensi_metodologi')->nullable();
            $table->longText('instruktur_kompetensi_teknis')->nullable();
            $table->longText('instruktur_pengalaman_kerja')->nullable();
            $table->longText('instruktur_persyaratan_khusus')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('general_informations', function (Blueprint $table) {
            $table->dropColumn([
                'document_id',
                'kode',
                'jenis_program',
                'metode_pelatihan',
                'tujuan',
                'jenis_standart_kompetensi',
                'persyaratan_pendidikan',
                'persyaratan_pelatihan',
                'persyaratan_pengalaman_kerja',
                'persyaratan_usia',
                'persyaratan_khusus_peserta',
                'instruktur_pendidikan_formal',
                'instruktur_kompetensi_metodologi',
                'instruktur_kompetensi_teknis',
                'instruktur_pengalaman_kerja',
                'instruktur_persyaratan_khusus',
            ]);
        });
    }
};
