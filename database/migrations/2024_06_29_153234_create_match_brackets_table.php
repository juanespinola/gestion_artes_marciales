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
        Schema::create('match_brackets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('victory_type_id')->nullable();
            $table->unsignedBigInteger('one_athlete_id')->nullable();
            $table->unsignedBigInteger('two_athlete_id')->nullable();
            $table->integer('quadrilateral'); // nro de cuadrilatero
            $table->date('match_date')->nullable(); // fecha de la lucha
            $table->time('match_time')->nullable(); // hora de la lucha
            $table->time('match_timer')->nullable(); // temporizador de la lucha
            $table->integer('score_one_athlete');
            $table->integer('score_two_athlete');
            $table->unsignedBigInteger('athlete_id_winner')->nullable();
            $table->unsignedBigInteger('athlete_id_loser')->nullable();
            $table->unsignedBigInteger('entry_category_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_brackets');
    }
};
