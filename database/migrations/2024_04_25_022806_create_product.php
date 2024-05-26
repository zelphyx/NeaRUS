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
        Schema::create('products', function (Blueprint $table) {
            $table->id('kostid');
            $table->string('image');
            $table->string('productname');
            $table->foreignId('ownerId');
            $table->string('location');
            $table->string('linklocation');
            $table->string('category');
            $table->string('fasilitas');
            $table->foreignId('roomid');
            $table->text("about");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
