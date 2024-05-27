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
        Schema::create('entry_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('age');
            $table->integer('weight')->nullable(); // si es null, se refiere a categoria maxima, absoluto
            $table->unsignedBigInteger('belt_id');
            $table->string('sex');
            $table->string('clothes')->nullable();
            $table->unsignedBigInteger('event_id');
            $table->timestamps();
            // $table->string('name');
            // $table->string('description');
            // $table->boolean('status')->default(true);
            // $table->integer('early_price')->nullable();
            // $table->integer('normal_price')->nullable();
            // $table->integer('late_price')->nullable();
            // $table->unsignedBigInteger('event_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entry_categories');
    }
};
