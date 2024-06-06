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
        Schema::create('level_belts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('belt_id');
            $table->unsignedBigInteger('athlete_id');
            $table->unsignedBigInteger('event_id')->nullable(); // cual fue el evento que se le dio ese cinturon
            $table->string('examiner')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('level_belts');
    }
};
