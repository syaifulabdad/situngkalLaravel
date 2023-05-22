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
        Schema::create('mata_pelajaran', function (Blueprint $table) {
            $table->string('mata_pelajaran_id', 36)->primary();
            $table->uuid('sekolah_id');
            $table->uuid('jurusan_id')->nullable();
            $table->integer('agama_id')->nullable();
            $table->string('kelompok')->nullable();
            $table->string('kode')->nullable();
            $table->string('kode2')->nullable();
            $table->string('mapel');
            $table->integer('no_urut')->nullable();

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
        Schema::dropIfExists('mata_pelajaran');
    }
};
