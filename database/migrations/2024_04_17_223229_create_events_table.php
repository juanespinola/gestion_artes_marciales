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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('description'); // Nombre para el evento
            $table->unsignedBigInteger('location_id');
            $table->date('initial_date');
            $table->date('final_date')->nullable();
            $table->string('initial_time');
            $table->string('final_time')->nullable();
            $table->unsignedBigInteger('type_event_id');
            $table->unsignedBigInteger('status_event_id');
            $table->integer('inscription_fee'); // precio de inscripcion
            $table->integer('total_participants')->nullable(); // total de participantes, cuando el evento finaliza la fecha de inscripcion, se debe actualizar esto
            $table->integer('available_slots');
            $table->unsignedBigInteger('created_user_id');
            $table->unsignedBigInteger('updated_user_id')->nullable();
            $table->unsignedBigInteger('federation_id');
            $table->unsignedBigInteger('association_id')->nullable();
            $table->longText('content')->nullable(); // contenido del evento
            $table->integer('quantity_quadrilateral')->default(0); // cantidad de cuadrilateros disponibles
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
