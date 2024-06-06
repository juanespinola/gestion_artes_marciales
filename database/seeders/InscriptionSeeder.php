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
                'weight' => '56.5',
            ],
            [
                'event_id' => 1,
                'athlete_id' => 2,
                'weight' => '80',
            ],
            [
                'event_id' => 1,
                'athlete_id' => 3,
                'weight' => '69.5',
            ],
            [
                'event_id' => 1,
                'athlete_id' => 4,
                'weight' => '99.5',
            ],
        ];

        foreach ($data as $key => $item) {
            Inscription::create($item);
        }
    }
}
