<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EntryCategory;


class EntryCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // [
            //     'name' => 'Men', 
            //     'description' => 'Categoria para Men',
            //     'early_price' => 50,
            //     'normal_price' => 100,
            //     'late_price' => 120,
            //     'event_id' => 1,
            // ],  
            // [
            //     'name' => 'Women', 
            //     'description' => 'Categoria para Women',
            //     'early_price' => 50,
            //     'normal_price' => 100,
            //     'late_price' => 120,
            //     'event_id' => 1,
            // ],  
            [
                'name' => 'Galo',
                'age'=> '30', // age maxima
                'weight'=> '57', // weight maximo
                'belt_id'=> 1,
                'sex'=> 'm',
                'clothes'=> 'gi',
                'event_id' => 1
            ],
            [
                'name' => 'Pluma',
                'age'=> '30', // age maxima
                'weight'=> '64', // weight maximo
                'belt_id'=> 1,
                'sex'=> 'm',
                'clothes'=> 'gi',
                'event_id' => 1
            ],
            [
                'name' => 'Pena',
                'age'=> '30', // age maxima
                'weight'=> '76', // weight maximo
                'belt_id'=> 1,
                'sex'=> 'm',
                'clothes'=> 'gi',
                'event_id' => 1
            ],
            // azul
            [
                'name' => 'Galo',
                'age'=> '30', // age maxima
                'weight'=> '57', // weight maximo
                'belt_id'=> 2,
                'sex'=> 'm',
                'clothes'=> 'gi',
                'event_id' => 1
            ],
            [
                'name' => 'Pluma',
                'age'=> '30', // age maxima
                'weight'=> '64', // weight maximo
                'belt_id'=> 2,
                'sex'=> 'm',
                'clothes'=> 'gi',
                'event_id' => 1
            ],
            [
                'name' => 'Pena',
                'age'=> '30', // age maxima
                'weight'=> '76', // weight maximo
                'belt_id'=> 2,
                'sex'=> 'm',
                'clothes'=> 'gi',
                'event_id' => 1
            ],
            //lila
            [
                'name' => 'Pena',
                'age'=> '30', // age maxima
                'weight'=> '76', // weight maximo
                'belt_id'=> 3,
                'sex'=> 'm',
                'clothes'=> 'gi',
                'event_id' => 1
            ],
            [
                'name' => 'Absoluto',
                'age'=> '30', // age maxima
                'weight'=> null, // weight maximo
                'belt_id'=> 1,
                'sex'=> 'm',
                'clothes'=> 'gi',
                'event_id' => 1
            ],
        ];

        foreach ($data as $key => $item) {
            EntryCategory::create($item);
        }
    }
}
