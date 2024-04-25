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
        Schema::create('associations', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->unsignedBigInteger('federation_id');
            $table->boolean('status')->default(true);
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('president')->nullable();
            $table->string('vice_president')->nullable();
            $table->string('treasurer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('associations');
    }
};
