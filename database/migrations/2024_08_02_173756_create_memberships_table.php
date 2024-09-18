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
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->integer('number_fee');
            $table->dateTime('start_date_fee');
            $table->dateTime('end_date_fee');
            $table->enum('status', ['pendiente', 'moroso', 'pagado']);
            $table->integer('amount_fee');
            $table->dateTime('payment_date_fee')->nullable();
            $table->unsignedBigInteger('type_membership_id');
            $table->unsignedBigInteger('athlete_id');
            $table->unsignedBigInteger('federation_id');
            $table->unsignedBigInteger('association_id');
            // $table->unsignedBigInteger('payment_id');
            $table->timestamps();
        });               
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
