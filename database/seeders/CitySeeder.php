<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\Country;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $country = Country::create([
            'name' => 'Paraguay',
        ]);
        
        $data = [
            ['name' => 'Asunción', 'country_id' => $country->id],
            ['name' => 'Ciudad del Este', 'country_id' => $country->id],
            ['name' => 'San Lorenzo', 'country_id' => $country->id],
            ['name' => 'Luque', 'country_id' => $country->id],
            ['name' => 'Capiatá', 'country_id' => $country->id],
            ['name' => 'Lambaré', 'country_id' => $country->id],
            ['name' => 'Fernando de la Mora', 'country_id' => $country->id],
            ['name' => 'Limpio', 'country_id' => $country->id],
            ['name' => 'Ñemby', 'country_id' => $country->id],
            ['name' => 'Encarnación', 'country_id' => $country->id],
        ];

        foreach ($data as $item) {
            City::create($item);
        }
    }
}
