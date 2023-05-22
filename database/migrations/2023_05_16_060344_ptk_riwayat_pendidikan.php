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
        Schema::create('ptk_riwayat_pendidikan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('ptk_id')->nullable();
            $table->uuid('peserta_didik_id')->nullable();
            $table->char('bidang_studi_id', 36)->nullable();
            $table->char('jenjang_pendidikan_id', 36)->nullable();
            $table->string('gelar_akademik')->nullable();
            $table->string('gelar_singkat')->nullable();
            $table->string('satuan_pendidikan')->nullable();

            $table->string('fakultas')->nullable();
            $table->string('kependidikan')->nullable();
            $table->tinyInteger('tahun_masuk')->nullable();
            $table->tinyInteger('tahun_lulus')->nullable();
            $table->string('nomor_induk')->nullable();
            $table->tinyInteger('status_kuliah')->nullable();
            $table->tinyInteger('semester')->nullable();
            $table->string('ipk')->nullable();
            $table->string('prodi')->nullable();

            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ptk_riwayat_pendidikan');
    }
};
