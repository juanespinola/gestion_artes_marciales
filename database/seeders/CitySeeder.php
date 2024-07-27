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
            'description' => 'Paraguay',
        ]);
        
        $data = [
            ['description' => 'Asunción', 'country_id' => $country->id],
            ['description' => 'Ciudad del Este', 'country_id' => $country->id],
            ['description' => 'San Lorenzo', 'country_id' => $country->id],
            ['description' => 'Luque', 'country_id' => $country->id],
            ['description' => 'Capiatá', 'country_id' => $country->id],
            ['description' => 'Lambaré', 'country_id' => $country->id],
            ['description' => 'Fernando de la Mora', 'country_id' => $country->id],
            ['description' => 'Limpio', 'country_id' => $country->id],
            ['description' => 'Ñemby', 'country_id' => $country->id],
            ['description' => 'Encarnación', 'country_id' => $country->id],
        ];

        foreach ($data as $item) {
            City::create($item);
        }

        $country = Country::create([
            'description' => 'Argentina',
        ]);
        
        $data = [
            ['description' => 'Formosa', 'country_id' => $country->id],
            ['description' => 'Buenos Aires', 'country_id' => $country->id],
        ];

        foreach ($data as $item) {
            City::create($item);
        }
    }
}
