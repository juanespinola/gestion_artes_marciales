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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inscription_id')->nullable();
            $table->unsignedBigInteger('membership_id')->nullable();
            $table->enum('payment_gateway', ['vpos', 'transferencia']);
            $table->mediumText('json_response')->nullable();
            $table->mediumText('json_request')->nullable();
            $table->mediumText('json_rollback')->nullable();
            $table->string('status', 50)->nullable();
            $table->unsignedBigInteger('federation_id');
            $table->unsignedBigInteger('association_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
