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
        Schema::create('group_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('group_category');
            // $table->string('description');
            $table->string('initial_value');
            $table->string('final_value')->nullable();
            $table->unsignedBigInteger('federation_id')->nullable();
            $table->unsignedBigInteger('association_id')->nullable();
            $table->timestamps();
        });
    }

    // EJEMPLO
    // 1, Edad, 10-11, 10, 11  (el inicio y final es para hacer comparacion)
    // 2, Edad, 12-13, 12, 13 

    // 3 Cinturon Cinturon Blanco blanco, null
    // 4 Cinturon Cinturon Azul Azul, null

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_categories');
    }
};
