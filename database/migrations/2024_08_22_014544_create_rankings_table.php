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
        Schema::create('rankings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('athlete_id');
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('entry_category_id');
            $table->integer('position')->nullable(); // Posición final en el torneo
            $table->integer('points')->nullable(); // Puntos obtenidos
            $table->integer('victories')->nullable(); // Número de victorias
            $table->integer('defeats')->nullable(); // Número de derrotas
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rankings');
    }
};