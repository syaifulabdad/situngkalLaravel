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
        Schema::create('ptk_riwayat_kepangkatan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('ptk_id');

            $table->string('nomor_sk')->nullable();
            $table->date('tanggal_sk')->nullable();
            $table->date('tmt_pangkat')->nullable();
            $table->integer('masa_kerja_gol_tahun')->nullable();
            $table->integer('masa_kerja_gol_bulan')->nullable();
            $table->string('pangkat_golongan_id', 36)->nullable();
            $table->string('golongan')->nullable();
            $table->string('sub_golongan')->nullable();
            $table->string('pangkat')->nullable();
            $table->string('pangkat_golongan')->nullable();

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
        Schema::dropIfExists('ptk_riwayat_kepangkatan');
    }
};
