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
        Schema::create('media_news', function (Blueprint $table) {
            $table->id();
            $table->string('name_file');
            $table->string('route_file');
            $table->enum('type', ['banner_new_list', 'banner_new_detail']);
            $table->unsignedBigInteger('new_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_news');
    }
};
