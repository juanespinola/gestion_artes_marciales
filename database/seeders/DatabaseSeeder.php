<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\FederationSeeder;
use Database\Seeders\CreateUsersSeeder;
use Database\Seeders\AssociationSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\SportSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\GroupCategorySeeder;
use Database\Seeders\EventSeeder;
use Database\Seeders\StatusEventSeeder;
use Database\Seeders\TypesEventSeeder;


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
            TypesEventSeeder::class
        ]);
    }
}
