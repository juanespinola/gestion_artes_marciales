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
            // adulto
            [
                'name' => 'Galo',
                'min_age'=> '18', // age minima
                'max_age'=> '30', // age maxima
                'min_weight'=> '52', // weight minimo
                'max_weight'=> '57', // weight maximo
                'belt_id'=> 1,
                'gender'=> 'masculino',
                'clothes'=> 'gi',
                'event_id' => 1
            ],
            [
                'name' => 'Pluma',
                'min_age'=> '18', // age minima
                'max_age'=> '30', // age maxima
                'min_weight'=> '58', // weight maximo
                'max_weight'=> '64', // weight maximo
                'belt_id'=> 1,
                'gender'=> 'masculino',
                'clothes'=> 'gi',
                'event_id' => 1
            ],
            [
                'name' => 'Pena',
                'min_age'=> '18', // age minima
                'max_age'=> '30', // age maxima
                'min_weight'=> '65', // weight maximo
                'max_weight'=> '76', // weight maximo
                'belt_id'=> 1,
                'gender'=> 'masculino',
                'clothes'=> 'gi',
                'event_id' => 1
            ],
            // jovenes
            [
                'name' => 'Galo',
                'min_age'=> '12', // age minima
                'max_age'=> '17', // age maxima
                'min_weight'=> '52', // weight maximo
                'max_weight'=> '57', // weight maximo
                'belt_id'=> 1,
                'gender'=> 'masculino',
                'clothes'=> 'gi',
                'event_id' => 1
            ],
            [
                'name' => 'Pluma',
                'min_age'=> '12', // age minima
                'max_age'=> '17', // age maxima
                'min_weight'=> '58', // weight maximo
                'max_weight'=> '64', // weight maximo
                'belt_id'=> 1,
                'gender'=> 'masculino',
                'clothes'=> 'gi',
                'event_id' => 1
            ],
            [
                'name' => 'Pena',
                'min_age'=> '12', // age minima
                'max_age'=> '17', // age maxima
                'min_weight'=> '65', // weight maximo
                'max_weight'=> '76', // weight maximo
                'belt_id'=> 1,
                'gender'=> 'masculino',
                'clothes'=> 'gi',
                'event_id' => 1
            ],
            // azul
            [
                'name' => 'Galo',
                'min_age'=> '18', // age minima
                'max_age'=> '30', // age maxima
                'min_weight'=> '52', // weight minimo
                'max_weight'=> '57', // weight maximo
                'belt_id'=> 2,
                'gender'=> 'masculino',
                'clothes'=> 'gi',
                'event_id' => 1
            ],
            [
                'name' => 'Pluma',
                'min_age'=> '18', // age minima
                'max_age'=> '30', // age maxima
                'min_weight'=> '58', // weight maximo
                'max_weight'=> '64', // weight maximo
                'belt_id'=> 2,
                'gender'=> 'masculino',
                'clothes'=> 'gi',
                'event_id' => 1
            ],
            [
                'name' => 'Pena',
                'min_age'=> '18', // age minima
                'max_age'=> '30', // age maxima
                'min_weight'=> '65', // weight maximo
                'max_weight'=> '76', // weight maximo
                'belt_id'=> 2,
                'gender'=> 'masculino',
                'clothes'=> 'gi',
                'event_id' => 1
            ],
            //lila
            [
                'name' => 'Pena',
                'min_age'=> '18', // age minima
                'max_age'=> '30', // age maxima
                'min_weight'=> '65', // weight maximo
                'max_weight'=> '76', // weight maximo
                'belt_id'=> 3,
                'gender'=> 'masculino',
                'clothes'=> 'gi',
                'event_id' => 1
            ],
            [
                'name' => 'Absoluto',
                'min_age'=> '18', // age minima
                'max_age'=> '30', // age maxima
                'min_weight'=> null, // weight maximo
                'max_weight'=> null, // weight maximo
                'belt_id'=> 3,
                'gender'=> 'masculino',
                'clothes'=> 'gi',
                'event_id' => 1
            ],
        ];

        foreach ($data as $key => $item) {
            EntryCategory::create($item);
        }
    }
}
