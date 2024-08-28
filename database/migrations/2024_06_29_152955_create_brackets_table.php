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
        Schema::create('brackets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('match_bracket_id');
            $table->integer('number_phase');
            $table->string('phase');
            $table->integer('step');
            $table->enum('status', ['pendiente', 'finalizado']);
            $table->unsignedBigInteger('type_bracket_id')->nullable(); // nos referimos al tipo de llaves utilizado
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brackets');
    }
};
