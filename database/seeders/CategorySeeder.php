<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['description' => 'Edad', 'sport_id' => 1, 'federation_id' => 1],
            ['description' => 'Peso', 'sport_id' => 1, 'federation_id' => 1],
            ['description' => 'Cinturon', 'sport_id' => 1, 'federation_id' => 1],
            ['description' => 'Genero', 'sport_id' => 1, 'federation_id' => 1],

            ['description' => 'Edad', 'sport_id' => 2, 'federation_id' => 2],
            ['description' => 'Peso', 'sport_id' => 2, 'federation_id' => 2],
            ['description' => 'Cinturon', 'sport_id' => 2, 'federation_id' => 2],
            ['description' => 'Genero', 'sport_id' => 2, 'federation_id' => 2],

            ['description' => 'Edad', 'sport_id' => 3, 'federation_id' => 3],
            ['description' => 'Peso', 'sport_id' => 3, 'federation_id' => 3],
            ['description' => 'Cinturon', 'sport_id' => 3, 'federation_id' => 3],
            ['description' => 'Genero', 'sport_id' => 3, 'federation_id' => 3],
        ];

        foreach ($data as $key => $item) {
            Category::create($item);
        }
    }
}
