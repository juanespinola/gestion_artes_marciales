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
            // tablas iniciales
            FederationSeeder::class,
            AssociationSeeder::class,
            StatusEventSeeder::class,
            TypesEventSeeder::class,
            CitySeeder::class,
            LocationSeeder::class,
            BeltSeeder::class,
            CategoryNewSeeder::class,
            TypeBracketSeeder::class,
            TypeVictorySeeder::class,
            TypeDocumentSeeder::class,
            TypesRequestSeeder::class,
            TypesMembershipsSeeder::class,
            // tablas iniciales
            
            // tablas principales
            CreateUsersSeeder::class,
            AthleteSeeder::class,
            FederationsAthletesSeeder::class,
            PermissionsSeeder::class,
            AcademySeeder::class,
            EventSeeder::class,
            EntryCategorySeeder::class,
            TariffInscriptionSeeder::class,
            InscriptionSeeder::class,
            BeltHistorySeeder::class,
            MediaNewsSeeder::class,
            // tablas principales

        ]);
    }
}
