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
            [
                'description' => 'Edad', 
                'federation_id' => 1
            ],
            [
                'description' => 'Peso', 
                'federation_id' => 1
            ],
            [
                'description' => 'Cinturon', 
                'federation_id' => 1
            ],
            [
                'description' => 'Genero', 
                'federation_id' => 1
            ],
            [
                'description' => 'Edad', 
                'federation_id' => 2,
                'association_id' => 3
            ],
            [
                'description' => 'Peso', 
                'federation_id' => 2,
                'association_id' => 3
            ],
            [
                'description' => 'Edad', 
                'federation_id' => 2,
                'association_id' => 3
            ],
           
        ];

        foreach ($data as $key => $item) {
            Category::create($item);
        }
    }
}
