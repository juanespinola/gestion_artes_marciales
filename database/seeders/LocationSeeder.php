<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'description' => 'Secretaria nacional de Deporte SND',
                'city_id' => 1,
                'address' => 'Calle 1 y Calle 2'
            ],
            [
                'description' => 'Garden Club Paraguayo',
                'city_id' => 1,
                'address' => 'Calle 1 y Calle 2'
            ],
        ];

        foreach ($data as $key => $item) {
            Location::create($item);
        }
    }
}
