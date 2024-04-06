<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GroupCategory;

class GroupCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'category_id' => 1,
                'group_category' => '10 - 12',
                'initial_value' => 10, 
                'final_value' => 12,
                'federation_id' => 1
            ],
            [
                'category_id' => 1,
                'group_category' => '13 - 14', 
                'initial_value' => 13, 
                'final_value' => 14,
                'federation_id' => 1
            ],
            [
                'category_id' => 3,
                'group_category' => 'Cinturon blanco', 
                'initial_value' => 'blanco', 
                'final_value' => null,
                'federation_id' => 1
            ],
            [
                'category_id' => 3,
                'group_category' => 'Cinturon Azul', 
                'initial_value' => 'azul', 
                'final_value' => null,
                'federation_id' => 1
            ],
            [
                'category_id' => 4,
                'group_category' => 'Genero Masculino', 
                'initial_value' => 'masculino', 
                'final_value' => null,
                'federation_id' => 1
            ],
            [
                'category_id' => 4,
                'group_category' => 'Genero Femenino', 
                'initial_value' => 'femenino', 
                'final_value' => null,
                'federation_id' => 1
            ],
        ];

        foreach ($data as $key => $item) {
            GroupCategory::create($item);
        }
    }
}
