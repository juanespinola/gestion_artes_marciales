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
        Schema::table('users', function (Blueprint $table) {
            $table->foreign(['federation_id'])->references(['id'])->on('federations')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['association_id'])->references(['id'])->on('associations')->onUpdate('restrict')->onDelete('restrict');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->foreign(['federation_id'])->references(['id'])->on('federations')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['association_id'])->references(['id'])->on('associations')->onUpdate('restrict')->onDelete('restrict');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->foreign(['location_id'])->references(['id'])->on('locations')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['federation_id'])->references(['id'])->on('federations')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['association_id'])->references(['id'])->on('associations')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['created_user_id'])->references(['id'])->on('users')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['updated_user_id'])->references(['id'])->on('users')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['type_event_id'])->references(['id'])->on('types_events')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['status_event_id'])->references(['id'])->on('status_events')->onUpdate('restrict')->onDelete('restrict');
        });


        Schema::table('locations', function (Blueprint $table) {
            $table->foreign(['city_id'])->references(['id'])->on('cities')->onUpdate('restrict')->onDelete('restrict');
        });
        
        Schema::table('entry_categories', function (Blueprint $table) {
            $table->foreign(['event_id'])->references(['id'])->on('events')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['belt_id'])->references(['id'])->on('belts')->onUpdate('restrict')->onDelete('restrict');
        });

        Schema::table('belts', function (Blueprint $table) {
            $table->foreign(['federation_id'])->references(['id'])->on('federations')->onUpdate('restrict')->onDelete('restrict');
        });

        Schema::table('athletes', function (Blueprint $table) {
            $table->foreign(['country_id'])->references(['id'])->on('countries')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['city_id'])->references(['id'])->on('cities')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['type_document_id'])->references(['id'])->on('type_documents')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['belt_id'])->references(['id'])->on('belts')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['academy_id'])->references(['id'])->on('academies')->onUpdate('restrict')->onDelete('restrict');
        });
        Schema::table('inscriptions', function (Blueprint $table) {
            $table->foreign(['event_id'])->references(['id'])->on('events')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['athlete_id'])->references(['id'])->on('athletes')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['tariff_inscription_id'])->references(['id'])->on('tariff_inscriptions')->onUpdate('restrict')->onDelete('restrict');
        });
        
        Schema::table('tariff_inscriptions', function (Blueprint $table) {
            $table->foreign(['entry_category_id'])->references(['id'])->on('entry_categories')->onUpdate('restrict')->onDelete('restrict');
        });

        Schema::table('level_belts', function (Blueprint $table) {
            $table->foreign(['belt_id'])->references(['id'])->on('belts')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['athlete_id'])->references(['id'])->on('athletes')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['event_id'])->references(['id'])->on('events')->onUpdate('restrict')->onDelete('restrict');
        });

        Schema::table('cities', function (Blueprint $table) {
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });

        Schema::table('news', function (Blueprint $table) {
            $table->foreign(['created_user_id'])->references(['id'])->on('users')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['updated_user_id'])->references(['id'])->on('users')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['federation_id'])->references(['id'])->on('federations')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['association_id'])->references(['id'])->on('associations')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['new_category_id'])->references(['id'])->on('category_news')->onUpdate('restrict')->onDelete('restrict');
        });

        Schema::table('media_news', function (Blueprint $table) {
            $table->foreign(['new_id'])->references(['id'])->on('news')->onUpdate('restrict')->onDelete('restrict');
        });

        Schema::table('brackets', function (Blueprint $table) {
            $table->foreign(['match_bracket_id'])->references(['id'])->on('match_brackets')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['type_bracket_id'])->references(['id'])->on('type_brackets')->onUpdate('restrict')->onDelete('restrict');
        });

        Schema::table('match_brackets', function (Blueprint $table) {
            $table->foreign(['event_id'])->references(['id'])->on('events')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['victory_type_id'])->references(['id'])->on('types_victories')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['one_athlete_id'])->references(['id'])->on('athletes')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['two_athlete_id'])->references(['id'])->on('athletes')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['athlete_id_winner'])->references(['id'])->on('athletes')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['athlete_id_loser'])->references(['id'])->on('athletes')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['entry_category_id'])->references(['id'])->on('entry_categories')->onUpdate('restrict')->onDelete('restrict');
        });

        Schema::table('academies', function (Blueprint $table) {
            $table->foreign(['federation_id'])->references(['id'])->on('federations')->onUpdate('restrict')->onDelete('restrict');
        });

        Schema::table('belt_histories', function (Blueprint $table) {
            $table->foreign(['belt_id'])->references(['id'])->on('belts')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['athlete_id'])->references(['id'])->on('athletes')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['federation_id'])->references(['id'])->on('federations')->onUpdate('restrict')->onDelete('restrict');
        });

        Schema::table('request_autorizations', function (Blueprint $table) {
            $table->foreign(['federation_id'])->references(['id'])->on('federations')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['association_id'])->references(['id'])->on('associations')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['request_type_id'])->references(['id'])->on('type_requests')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['athlete_id'])->references(['id'])->on('athletes')->onUpdate('restrict')->onDelete('restrict');
        });

        Schema::table('type_requests', function (Blueprint $table) {
            $table->foreign(['federation_id'])->references(['id'])->on('federations')->onUpdate('restrict')->onDelete('restrict');
        });

        Schema::table('type_memberships', function (Blueprint $table) {
            $table->foreign(['federation_id'])->references(['id'])->on('federations')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['association_id'])->references(['id'])->on('associations')->onUpdate('restrict')->onDelete('restrict');
        });
        

        Schema::table('memberships', function (Blueprint $table) {
            $table->foreign(['federation_id'])->references(['id'])->on('federations')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['association_id'])->references(['id'])->on('associations')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['athlete_id'])->references(['id'])->on('athletes')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['type_membership_id'])->references(['id'])->on('type_memberships')->onUpdate('restrict')->onDelete('restrict');
        });


        Schema::table('payments', function (Blueprint $table) {
            $table->foreign(['federation_id'])->references(['id'])->on('federations')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['association_id'])->references(['id'])->on('associations')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['inscription_id'])->references(['id'])->on('inscriptions')->onUpdate('restrict')->onDelete('restrict');
        });

        Schema::table('rankings', function (Blueprint $table) {
            $table->foreign(['athlete_id'])->references(['id'])->on('athletes')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['event_id'])->references(['id'])->on('events')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['entry_category_id'])->references(['id'])->on('entry_categories')->onUpdate('restrict')->onDelete('restrict');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('add_foreign_keys');
        // $table->dropForeign('access_local_show_product_id_foreign');
    }
};
