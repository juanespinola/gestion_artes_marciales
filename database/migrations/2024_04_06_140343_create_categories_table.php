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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->unsignedBigInteger('federation_id');
            $table->unsignedBigInteger('association_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }



    // Schema::table('bookings', function (Blueprint $table) {
    //     $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
    //     $table->foreign('reservation_place_id')->references('id')->on('reservation_places')->onDelete('cascade'); 
    // });
};
