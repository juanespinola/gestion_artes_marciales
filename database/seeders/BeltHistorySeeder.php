<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BeltHistory;

class BeltHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'belt_id' => '1',
                'athlete_id' => '1',
                'federation_id' => '1',
                // 'achieved' => '',
                'promoted_by' => '',
            ],  
            [
                'belt_id' => '2',
                'athlete_id' => '1',
                'federation_id' => '1',
                // 'achieved' => '',
                'promoted_by' => 'Marcos Curril',
            ],    
        ];

        foreach ($data as $key => $item) {
            BeltHistory::create($item);
        }
    }
}
