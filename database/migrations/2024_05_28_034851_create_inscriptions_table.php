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
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('athlete_id');
            $table->double('event_weight'); // el peso del atleta en el pesaje del evento.
            $table->boolean('valid_weight')->default(false);
            $table->unsignedBigInteger('tariff_inscription_id');
            // $table->unsignedBigInteger('payment_id')->nullable();
            // $table->string('status');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscriptions');
    }
};
