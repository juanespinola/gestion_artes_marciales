<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ValueCategory;

class ValueCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Blanco', 
                'description' => 'Cinturon Blanco',
                'value' => 'blanco',
                'class_category_id' => 1
            ],  
            [
                'name' => 'Azul', 
                'description' => 'Cinturon Azul',
                'value' => 'azul',
                'class_category_id' => 1
            ],  
            [
                'name' => 'Lila', 
                'description' => 'Cinturon Lila',
                'value' => 'lila',
                'class_category_id' => 1
            ],  
            [
                'name' => 'Marron', 
                'description' => 'Cinturon Marron',
                'value' => 'marron',
                'class_category_id' => 1
            ],  
            [
                'name' => 'Negro', 
                'description' => 'Cinturon Negro',
                'value' => 'negro',
                'class_category_id' => 1
            ], 
        ];

        foreach ($data as $key => $item) {
            ValueCategory::create($item);
        }
    }
}
