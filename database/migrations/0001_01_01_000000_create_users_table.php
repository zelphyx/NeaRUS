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
            $table->id('ownerId');
            $table->string('buktiimage')->nullable();
            $table->string('photoprofile')->nullable();
            $table->string('name');
            $table->string('websiterole');
            $table->string('email')->unique();
            $table->string('phonenumber');
            $table->string('password');
            $table->string('jenis_kelamin')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('alamat_rumah')->nullable();
            $table->string('urgent_fullname')->nullable();
            $table->string('urgent_status')->nullable();
            $table->string('urgent_phonenumber')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('email_verification_token')->nullable()->unique();
            $table->rememberToken();
            $table->string('reset_password_token', 60)->nullable();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
