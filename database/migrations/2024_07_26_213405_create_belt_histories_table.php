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
        Schema::create('belt_histories', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('created_user_id')->index('news_created_user_id_foreign');
            $table->unsignedBigInteger('belt_id');
            $table->unsignedBigInteger('athlete_id');
            $table->unsignedBigInteger('federation_id');
            $table->date('achieved')->nullable();
            $table->string('promoted_by')->nullable();
            $table->timestamps();
        });            
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('belt_histories');
    }
};
