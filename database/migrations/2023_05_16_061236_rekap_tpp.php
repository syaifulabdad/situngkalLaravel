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
        Schema::create('rekap_tpp', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('tahun')->nullable();
            $table->integer('bulan')->nullable();
            $table->string('kecamatan_id')->nullable();
            $table->string('kecamatan')->nullable();
            $table->uuid('sekolah_id')->nullable();
            $table->string('nama_sekolah')->nullable();

            $table->uuid('ptk_id')->nullable();
            $table->string('nama')->nullable();
            $table->string('nik')->nullable();
            $table->string('nip')->nullable();
            $table->string('nuptk')->nullable();
            $table->string('jenis_ptk_id')->nullable();
            $table->string('jenis_ptk')->nullable();
            $table->string('jabatan_id')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('status_kepegawaian_id')->nullable();
            $table->string('status_kepegawaian')->nullable();
            $table->string('sertifikasi')->nullable();
            $table->string('bidang_studi_id')->nullable();
            $table->string('bidang_studi')->nullable();
            $table->string('pangkat_golongan_id')->nullable();
            $table->string('pangkat_golongan')->nullable();
            $table->string('golongan')->nullable();
            $table->integer('gaji_pokok')->nullable();
            $table->integer('gaji_perbulan')->nullable();
            $table->string('nomor_rekening')->nullable();
            $table->string('nama_bank')->nullable();
            $table->string('npwp')->nullable();

            $table->uuid('jenis_tpp_id')->nullable();
            $table->string('jenis_tpp')->nullable();
            $table->integer('tpp_perbulan')->nullable();
            $table->integer('jumlah_hari_sebulan')->nullable();
            $table->integer('jumlah_hari_kerja')->nullable();
            $table->integer('jumlah_hari_minggu')->nullable();
            $table->integer('jumlah_hari_libur')->nullable();
            $table->integer('hadir')->nullable();
            $table->integer('izin')->nullable();
            $table->integer('cuti')->nullable();
            $table->integer('dinas_luar')->nullable();
            $table->integer('sakit')->nullable();
            $table->integer('jumlah_izin')->nullable();
            $table->integer('jumlah_hadir')->nullable();
            $table->integer('jumlah_alpa')->nullable();
            $table->integer('terlambat')->nullable();
            $table->integer('pulang_cepat')->nullable();
            $table->integer('persentase_kehadiran')->nullable();
            $table->integer('jumlah_tpp_kinerja')->nullable();
            $table->integer('jumlah_tpp_disiplin')->nullable();
            $table->integer('pph21')->nullable();
            $table->integer('bpjs4')->nullable();
            $table->integer('jumlah_tpp_kotor')->nullable();
            $table->integer('bpjs1')->nullable();
            $table->integer('jumlah_potongan')->nullable();
            $table->integer('jumlah_tpp_diterima')->nullable();
            $table->integer('zakat')->nullable();
            $table->integer('total_tpp_diterima')->nullable();

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
        Schema::dropIfExists('rekap_tpp');
    }
};
