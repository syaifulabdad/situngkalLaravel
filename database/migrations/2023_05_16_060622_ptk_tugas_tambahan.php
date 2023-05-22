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
        Schema::create('ptk_tugas_tambahan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('ptk_id');

            $table->string('jabatan_id', 36)->nullable();
            $table->integer('jumlah_jam')->nullable();
            $table->string('nomor_sk')->nullable();
            $table->date('tmt_sk')->nullable();
            $table->date('tst_sk')->nullable();

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
        Schema::dropIfExists('ptk_tugas_tambahan');
    }
};
