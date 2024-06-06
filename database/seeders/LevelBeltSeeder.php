<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LevelBelt;

class LevelBeltSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'belt_id' => 1,
                'event_id' => 1,
                'athlete_id' => 1,
                'examiner' => 'Juan Espinola',
                'status'=> 'Aprobado'
            ],  
           
        ];

        foreach ($data as $key => $item) {
            LevelBelt::create($item);
        }
    }
}
