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
        Schema::create('type_memberships', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->integer('price');
            $table->integer('total_number_fee');
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('federation_id');
            $table->unsignedBigInteger('association_id')->nullable();
            $table->timestamps();           
        });
    }
    // aca manejamos el tipo de membresia con su precio, que hace generar las cuotas
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_memberships');
    }
};
