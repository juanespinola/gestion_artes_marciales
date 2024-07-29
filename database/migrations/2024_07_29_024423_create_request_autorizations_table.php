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
        Schema::create('request_autorizations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('federation_id');
            $table->unsignedBigInteger('association_id');
            $table->unsignedBigInteger('requested_by')->nullable(); 
            $table->unsignedBigInteger('approved_by')->nullable(); 
            $table->unsignedBigInteger('rejected_by')->nullable(); 
            $table->date('date_request');
            $table->date('date_response')->nullable();
            $table->unsignedBigInteger('request_type_id');
            $table->mediumText('request_text')->nullable();
            $table->mediumText('response_text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_autorizations');
    }
};
