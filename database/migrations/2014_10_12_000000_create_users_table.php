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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('user_id')->primary();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('username')->nullable();

            $table->uuid('sekolah_id')->nullable();
            $table->uuid('ptk_id')->nullable();
            $table->uuid('peserta_didik_id')->nullable();

            $table->string('user_type')->nullable();
            $table->uuid('group_id')->nullable();
            $table->string('image')->nullable();
            $table->string('google_id', 100)->nullable();
            $table->string('status', 20)->default('active');
            $table->dateTime('last_login')->nullable();
            $table->string('kecamatan_id')->nullable();

            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
