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
        Schema::create('owner_request', function (Blueprint $table) {
            $table->id('requestId');
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
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('owner_request');
    }
};
