<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Athlete;

class AthleteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Athlete::factory()->count(10)->create();
        // $data = [
        //     [
        //         'name' => 'athlete 1 ',
        //         'email' => 'athlete1@gmail.com',
        //         'password' => bcrypt('123456'),
        //         'country_id' => '1',
        //         'city_id' => '1',
        //         'type_document_id' => '1',
        //         'document' => '123456',
        //         'phone' => '+5950981123456',
        //         'gender' => 'masculino',
        //         'birthdate' => '10/19/1996',
        //         'belt_id' => 1
        //     ],
      
        // ];

        // foreach ($data as $key => $item) {
        //     Athlete::create($item);
        // }

        for ($i=1; $i < 11; $i++) { 
            Athlete::create(
                [
                    'name' => 'athlete '.$i,
                    'email' => "athlete{$i}@gmail.com",
                    'password' => bcrypt('123456'),
                    'country_id' => 1,
                    'city_id' => 1,
                    'type_document_id' => 1,
                    'document' => '123456',
                    'phone' => '+5950981123456',
                    'gender' => 'masculino',
                    'birthdate' => '10/19/1996',
                    'belt_id' => 1
                ],
            );
        }
    }
}
