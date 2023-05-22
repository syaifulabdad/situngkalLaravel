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
        Schema::create('ptk_terdaftar', function (Blueprint $table) {
            $table->uuid('ptk_terdaftar_id')->primary();
            $table->uuid('sekolah_id');
            $table->uuid('ptk_id');

            $table->string('jenis_pendaftaran_id', 36)->nullable();
            $table->date('tanggal_masuk');
            $table->tinyInteger('tahun_masuk')->nullable();
            $table->string('jenis_keluar_id', 36)->default(0);
            $table->date('tanggal_keluar')->nullable();
            $table->tinyInteger('tahun_keluar')->nullable();
            $table->tinyInteger('induk')->default(1);
            $table->uuid('user_id')->nullable();

            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('ptk_id')->references('ptk_id')->on('ptk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ptk_terdaftar');
    }
};
