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
        Schema::create('product_room', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kostid');
            $table->unsignedBigInteger('roomid');
            $table->timestamps();

            $table->foreign('kostid')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('roomid')->references('id')->on('rooms')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_room');
    }
};
