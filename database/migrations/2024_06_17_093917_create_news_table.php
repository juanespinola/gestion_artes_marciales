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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('content');
            $table->enum('status', ['pendiente', 'activo', 'inactivo'])->default('pendiente');
            $table->unsignedBigInteger('created_user_id')->index('news_created_user_id_foreign');
            $table->unsignedBigInteger('updated_user_id')->nullable()->index('news_updated_user_id_foreign');
            $table->unsignedBigInteger('federation_id')->index('news_federation_id_foreign');
            $table->unsignedBigInteger('association_id')->nullable()->index('news_association_id_foreign');
            $table->timestamps();

            $table->foreign(['created_user_id'])->references(['id'])->on('users')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['updated_user_id'])->references(['id'])->on('users')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['federation_id'])->references(['id'])->on('federations')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['association_id'])->references(['id'])->on('associations')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
