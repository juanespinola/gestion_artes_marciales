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
        // almacenamiento de imagenes, rutas, etc 
        // recomendable hacer en la vista de eventos, un tab para subir las imagenes una vez que se crea el evento
        // donde almacene localmente, y le dividas en panel principal y otros en sliders
        // https://es.stackoverflow.com/questions/603214/problema-al-guardar-imagenes-laravel-10-tmp
        Schema::create('media_events', function (Blueprint $table) {
            $table->id();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_events');
    }
};
