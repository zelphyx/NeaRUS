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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id('roomid');
            $table->foreignId('ownerId');
            $table->string("name");
            $table->string("category");
            $table->string("fasilitas");
            $table->string("image");
            $table->integer("price");
            $table->string("time");
            $table->integer("availability");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
