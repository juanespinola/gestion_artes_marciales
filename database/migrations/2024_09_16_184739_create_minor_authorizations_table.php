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
        Schema::create('minor_authorizations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('athlete_id')->unique();
            $table->string('name_file')->nullable();
            $table->string('route_file')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->boolean('authorized')->default(false);
            $table->unsignedBigInteger('federation_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('minor_authorizations');
    }
};
