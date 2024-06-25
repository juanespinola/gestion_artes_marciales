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
        Schema::create('associations', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->unsignedBigInteger('federation_id')->index('associations_federation_id_foreign');
            $table->boolean('status')->default(true);
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('president')->nullable();
            $table->string('vice_president')->nullable();
            $table->string('treasurer')->nullable();
            $table->string('facebook')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->timestamps();

            $table->foreign(['federation_id'])->references(['id'])->on('federations')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('associations');
        
        // Schema::table('detail_requireds', function (Blueprint $table) {
        //     $table->dropForeign('detail_requireds_user_id_foreign');
        // });

    }
};
