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
        Schema::create('jurusan', function (Blueprint $table) {
            $table->uuid('jurusan_id')->primary();
            $table->string('dapodik_jurusan_id', 36)->nullable();
            $table->uuid('sekolah_id');
            $table->uuid('kurikulum_id')->nullable();
            $table->string('kode')->nullable();
            $table->string('jurusan');
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
        Schema::dropIfExists('jurusan');
    }
};
