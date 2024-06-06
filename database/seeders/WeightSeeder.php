<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Weight;

class WeightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => '',
                'min_weight' => '1000',
                'man_weight' => '',
                'with_clothes' => false,
                'federation_id' => 1
            ],            
        ];

        foreach ($data as $key => $item) {
            Weight::create($item);
        }
    
    }
}
