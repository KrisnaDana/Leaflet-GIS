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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->foreignId("hotel_id")->constrained("hotels");
            $table->unsignedBigInteger('room_id')->default(0);
            $table->enum('type', ['Hotel', 'Room']);
            $table->boolean("is_thumbnail")->default(0);
            $table->string("filename");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
