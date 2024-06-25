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
        Schema::create('federations_athletes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('athlete_id')->index('federations_athletes_athlete_id_foreign');
            $table->unsignedBigInteger('federation_id')->index('federations_athletes_federation_id_foreign');
            $table->unsignedBigInteger('association_id')->nullable()->index('federations_athletes_association_id_foreign');
            $table->timestamps();

            $table->foreign(['athlete_id'])->references(['id'])->on('athletes')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['federation_id'])->references(['id'])->on('federations')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['association_id'])->references(['id'])->on('associations')->onUpdate('restrict')->onDelete('restrict');
    
        });

      
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('federations_athletes');
    }
};
