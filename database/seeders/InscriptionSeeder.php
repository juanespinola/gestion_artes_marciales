<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Inscription;

class InscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'event_id' => 1,
                'athlete_id' => 1,
                'tariff_inscription_id' => '2',
            ],
            [
                'event_id' => 1,
                'athlete_id' => 2,
                'tariff_inscription_id' => '2',
            ],
            [
                'event_id' => 1,
                'athlete_id' => 3,
                'tariff_inscription_id' => '2',
            ],
            [
                'event_id' => 1,
                'athlete_id' => 4,
                'tariff_inscription_id' => '2',
            ],
            [
                'event_id' => 1,
                'athlete_id' => 5,
                'tariff_inscription_id' => '2',
            ],
            [
                'event_id' => 1,
                'athlete_id' => 6,
                'tariff_inscription_id' => '9',
            ],
            [
                'event_id' => 1,
                'athlete_id' => 7,
                'tariff_inscription_id' => '9',
            ],
            [
                'event_id' => 1,
                'athlete_id' => 8,
                'tariff_inscription_id' => '12',
            ],
            [
                'event_id' => 1,
                'athlete_id' => 9,
                'tariff_inscription_id' => '12',
            ],
            [
                'event_id' => 1,
                'athlete_id' => 10,
                'tariff_inscription_id' => '12',
            ],
            
        ];

        foreach ($data as $key => $item) {
            Inscription::create($item);
        }
    }
}
