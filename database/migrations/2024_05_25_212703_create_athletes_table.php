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
        Schema::create('athletes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('type_document_id');
            $table->string('document', 50);
            $table->string('phone')->nullable();
            $table->string('gender');
            $table->date('birthdate');
            // $table->double('weight');
            $table->string('profile_image')->nullable();
            $table->unsignedBigInteger('belt_id')->nullable();
            $table->string('type')->default('athlete');
            $table->unsignedBigInteger('academy_id')->nullable();
            $table->boolean('is_minor')->default(false);
            $table->boolean('minor_verified')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('athletes');
    }
};
