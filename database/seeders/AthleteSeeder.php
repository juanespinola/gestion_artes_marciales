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
        $data = [
            [
                'name' => 'athlete 1 ',
                'email' => 'athlete1@gmail.com',
                'password' => bcrypt('123456'),
                // 'federation_id' => '1',
                // 'association_id' => '2',
                'country_id' => '1',
                'city_id' => '1',
                'type_document_id' => '1',
                'document' => '123456',
                'phone' => '+5950981123456',
                'gender' => 'masculino',
                'birthdate' => '10/19/1996',
                // 'weight' => '56.5',
                'belt_id' => 1
            ],
            [
                'name' => 'athlete 2',
                'email' => 'athlete2@gmail.com',
                'password'=> bcrypt('123456'),
                // 'federation_id'=> '1',
                // 'association_id'=> '2',
                'country_id' => '1',
                'city_id' => '1',
                'type_document_id' => '1',
                'document' => '123456',
                'phone' => '+5950981123456',
                'gender' => 'masculino',
                'birthdate' => '10/19/1994',
                // 'weight' => '80'
            ],
            [
                'name' => 'athlete 3',
                'email' => 'athlete3@gmail.com',
                'password'=> bcrypt('123456'),
                // 'federation_id'=> '1',
                // 'association_id'=> '2',
                'country_id' => '1',
                'city_id' => '1',
                'type_document_id' => '1',
                'document' => '123456',
                'phone' => '+5950981123456',
                'gender' => 'masculino',
                'birthdate' => '04/04/2024',
                // 'weight' => '69.5'
            ],
            [
                'name' => 'athlete 4',
                'email' => 'athlete4@gmail.com',
                'password'=> bcrypt('123456'),
                // 'federation_id'=> '1',
                // 'association_id'=> '2',
                'country_id' => '1',
                'city_id' => '1',
                'type_document_id' => '1',
                'document' => '123456',
                'phone' => '+5950981123456',
                'gender' => 'masculino',
                'birthdate' => '04/04/2024',
            ],
            [
                'name' => 'athlete 5',
                'email' => 'athlete5@gmail.com',
                'password'=> bcrypt('123456'),
                // 'federation_id'=> '1',
                // 'association_id'=> '2',
                'country_id' => '1',
                'city_id' => '1',
                'type_document_id' => '1',
                'document' => '123456',
                'phone' => '+5950981123456',
                'gender' => 'masculino',
                'birthdate' => '04/04/2024',
            ],
            [
                'name' => 'athlete 6',
                'email' => 'athlete6@gmail.com',
                'password'=> bcrypt('123456'),
                // 'federation_id'=> '1',
                // 'association_id'=> '2',
                'country_id' => '1',
                'city_id' => '1',
                'type_document_id' => '1',
                'document' => '123456',
                'phone' => '+5950981123456',
                'gender' => 'masculino',
                'birthdate' => '04/04/2024',
            ],
            [
                'name' => 'athlete 7',
                'email' => 'athlete7@gmail.com',
                'password'=> bcrypt('123456'),
                // 'federation_id'=> '1',
                // 'association_id'=> '2',
                'country_id' => '1',
                'city_id' => '1',
                'type_document_id' => '1',
                'document' => '123456',
                'phone' => '+5950981123456',
                'gender' => 'masculino',
                'birthdate' => '04/04/2024',
            ],
            [
                'name' => 'athlete 8',
                'email' => 'athlete8@gmail.com',
                'password'=> bcrypt('123456'),
                // 'federation_id'=> '1',
                // 'association_id'=> '2',
                'country_id' => '1',
                'city_id' => '1',
                'type_document_id' => '1',
                'document' => '123456',
                'phone' => '+5950981123456',
                'gender' => 'femenino',
                'birthdate' => '04/04/2024',
            ],
            [
                'name' => 'athlete 9',
                'email' => 'athlete9@gmail.com',
                'password'=> bcrypt('123456'),
                // 'federation_id'=> '1',
                // 'association_id'=> '2',
                'country_id' => '1',
                'city_id' => '1',
                'type_document_id' => '1',
                'document' => '123456',
                'phone' => '+5950981123456',
                'gender' => 'femenino',
                'birthdate' => '04/04/2024',
            ],
            [
                'name' => 'athlete 10',
                'email' => 'athlete10@gmail.com',
                'password'=> bcrypt('123456'),
                // 'federation_id'=> '1',
                // 'association_id'=> '2',
                'country_id' => '1',
                'city_id' => '1',
                'type_document_id' => '1',
                'document' => '123456',
                'phone' => '+5950981123456',
                'gender' => 'femenino',
                'birthdate' => '04/04/2024',
            ],
        ];

        foreach ($data as $key => $item) {
            Athlete::create($item);
        }
    }
}
