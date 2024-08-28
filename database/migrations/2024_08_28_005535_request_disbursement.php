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
        Schema::create('request_disbursement', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ownerId');
            $table->string('name');
            $table->string('phonenumber');
            $table->integer('amount');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
