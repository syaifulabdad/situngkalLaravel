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
        Schema::create('sekolah', function (Blueprint $table) {
            $table->uuid('sekolah_id')->primary();
            $table->uuid('dapodik_sekolah_id')->nullable();
            $table->string('nama');
            $table->string('nss')->nullable();
            $table->string('npsn')->unique();
            $table->enum('jenjang', ['PAUD', 'TK', 'KB', 'SD', 'SMP', 'SMA', 'SMK']);
            $table->enum('status_sekolah', ['Negeri', 'Swasta']);
            $table->text('alamat_jalan')->nullable();
            $table->integer('rt')->nullable();
            $table->integer('rw')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('koordinat')->nullable();
            $table->string('dusun')->nullable();
            $table->string('desa_kelurahan_id', 36)->nullable();
            $table->string('desa_kelurahan')->nullable();
            $table->string('kecamatan_id', 36)->nullable();
            $table->string('kabupaten_id', 36)->nullable();
            $table->string('provinsi_id', 36)->nullable();
            $table->string('email')->nullable();
            $table->string('nomor_telepon')->nullable();
            $table->string('nomor_fax')->nullable();
            $table->string('website')->nullable();

            $table->string('dapodik_url')->nullable();
            $table->string('token_api_dapodik')->nullable();
            $table->string('mode_tarik_data')->nullable();

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
        Schema::dropIfExists('sekolah');
    }
};
