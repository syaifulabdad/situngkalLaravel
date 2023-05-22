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
        Schema::create('ptk', function (Blueprint $table) {
            $table->uuid('ptk_id')->primary();
            $table->uuid('dapodik_ptk_id', 36)->nullable();
            $table->string('nama')->nullable();
            $table->string('inisial', 10)->nullable();
            $table->string('gelar_depan')->nullable();
            $table->string('gelar_belakang')->nullable();
            $table->string('nip', 20)->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->string('tanggal_lahir')->nullable();
            $table->string('nik')->nullable();
            $table->string('niy_nigk')->nullable();
            $table->string('nuptk')->nullable();
            $table->string('status_kepegawaian_id')->nullable();
            $table->string('jenis_ptk_id')->nullable();
            $table->integer('agama_id')->nullable();
            $table->string('alamat_jalan')->nullable();
            $table->smallInteger('rt')->nullable();
            $table->smallInteger('rw')->nullable();
            $table->string('nama_dusun')->nullable();
            $table->string('desa_kelurahan_id', 36)->nullable();
            $table->string('kecamatan_id', 36)->nullable();
            $table->string('kabupaten_id', 36)->nullable();
            $table->string('provinsi_id', 36)->nullable();
            $table->integer('kode_pos')->nullable();
            $table->string('koordinat_rumah')->nullable();
            $table->string('nomor_telepon_rumah')->nullable();
            $table->string('nomor_telepon_seluler')->nullable();
            $table->string('email')->nullable();
            $table->string('status_keaktifan_id')->nullable();
            $table->string('sk_cpns')->nullable();
            $table->string('tgl_cpns')->nullable();
            $table->string('sk_pengangkatan')->nullable();
            $table->string('tmt_pengangkatan')->nullable();
            $table->string('lembaga_pengangkat_id')->nullable();
            $table->string('sumber_gaji_id')->nullable();
            $table->string('nama_ibu_kandung')->nullable();
            $table->string('status_perkawinan')->nullable();
            $table->string('nama_suami_istri')->nullable();
            $table->string('nip_suami_istri')->nullable();
            $table->string('pekerjaan_suami_istri')->nullable();
            $table->string('tmt_pns')->nullable();
            $table->string('karpeg')->nullable();
            $table->string('karpas')->nullable();
            $table->string('npwp')->nullable();
            $table->string('kewarganegaraan')->nullable();

            $table->string('sertifikasi')->nullable();
            $table->integer('tahun_sertifikasi')->nullable();
            $table->string('nomor_sertifikat')->nullable();
            $table->string('nomor_peserta_sertifikasi')->nullable();
            $table->string('nrg')->nullable();
            $table->string('bidang_studi_id')->nullable();

            $table->uuid('jenis_tpp_id')->nullable();
            $table->integer('penerima_tpp_khusus')->default(0);

            $table->string('nomor_rekening')->nullable();
            $table->string('nama_bank')->nullable();

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
        Schema::dropIfExists('ptk');
    }
};
