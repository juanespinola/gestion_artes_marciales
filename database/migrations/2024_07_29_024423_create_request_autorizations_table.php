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
        Schema::create('request_autorizations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('federation_id');
            $table->unsignedBigInteger('association_id');
            $table->string('requested_by')->nullable(); 
            $table->string('approved_by')->nullable(); 
            $table->string('rejected_by')->nullable(); 
            $table->date('date_request');
            $table->date('date_response')->nullable();
            $table->unsignedBigInteger('request_type_id')->nullable();
            $table->mediumText('request_text')->nullable();
            $table->mediumText('response_text')->nullable();
            $table->enum('status', ['pendiente', 'respuesta', 'aprobado', 'rechazado'])->default('pendiente');
            $table->unsignedBigInteger('athlete_id')->nullable(); // para las solicitudes de membresia/cinturon referentes a athletas
            $table->unsignedBigInteger('event_id')->nullable(); // para las solicitudes de eventos
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_autorizations');
    }
};
