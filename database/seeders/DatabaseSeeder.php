<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            FederationSeeder::class,
            CreateUsersSeeder::class,
            AssociationSeeder::class,
            PermissionsSeeder::class,
            SportSeeder::class,
            CategorySeeder::class,
            GroupCategorySeeder::class,
            EventSeeder::class,
            LocationSeeder::class,
            StatusEventSeeder::class,
            TypesEventSeeder::class,
            EntryCategorySeeder::class,
            ClassCategorySeeder::class,
            ValueCategorySeeder::class,
            RuleCategorySeeder::class,
            BeltSeeder::class,
            AthleteSeeder::class,
            InscriptionSeeder::class,
            TariffInscriptionSeeder::class,
            CitySeeder::class,
            FederationsAthletesSeeder::class,
            // NewsSeeder::class,
            MediaNewsSeeder::class,
            CategoryNewSeeder::class,
            TypeBracketSeeder::class,
            TypeVictorySeeder::class,
            AcademySeeder::class,
            TypeDocumentSeeder::class,
            BeltHistorySeeder::class,
            // RequestAutorizationSeeder::class,
            TypesRequestSeeder::class,
            TypesMembershipsSeeder::class,

        ]);
    }
}
