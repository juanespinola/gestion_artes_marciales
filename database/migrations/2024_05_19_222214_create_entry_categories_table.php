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
            $table->integer('min_age');
            $table->integer('max_age');
            $table->double('min_weight')->nullable(); // si es null, se refiere a categoria maxima, absoluto
            $table->double('max_weight')->nullable(); // si es null, se refiere a categoria maxima, absoluto
            $table->unsignedBigInteger('belt_id');
            $table->string('gender');
            $table->string('clothes')->nullable();
            $table->unsignedBigInteger('event_id');
            $table->boolean('minor_category')->default(false);
            $table->timestamps();
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
