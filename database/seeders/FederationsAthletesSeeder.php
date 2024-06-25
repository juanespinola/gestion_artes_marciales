<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FederationsAthletes;

class FederationsAthletesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'federation_id' => '1',
                'association_id' => '2',
                'athlete_id' => '1',
            ],
            [
                'federation_id' => '2',
                'association_id' => '3',
                'athlete_id' => '1',
            ],
            [
                'federation_id' => '1',
                'association_id' => '2',
                'athlete_id' => '2',
            ],
            [
                'federation_id' => '1',
                'association_id' => '2',
                'athlete_id' => '3',
            ],
            [
                'federation_id' => '1',
                'association_id' => '2',
                'athlete_id' => '4',
            ],
            [
                'federation_id' => '1',
                'association_id' => '2',
                'athlete_id' => '5',
            ],
            [
                'federation_id' => '1',
                'association_id' => '2',
                'athlete_id' => '6',
            ],
            [
                'federation_id' => '1',
                'association_id' => '2',
                'athlete_id' => '7',
            ],
            [
                'federation_id' => '1',
                'association_id' => '2',
                'athlete_id' => '8',
            ],
            [
                'federation_id' => '1',
                'association_id' => '2',
                'athlete_id' => '9',
            ],
            [
                'federation_id' => '1',
                'association_id' => '2',
                'athlete_id' => '10',
            ],
        ];

        foreach ($data as $key => $item) {
            FederationsAthletes::create($item);
        }
    }
}
