<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ClassCategory;

class ClassCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // este es para Men
            [
                'name' => 'Cinturon', 
                'description' => 'Clase Cinturon',
                'value' => 'cinturon',
                'entry_category_id' => 1
            ],  
            [
                'name' => 'Peso', 
                'description' => 'Clase Peso',
                'value' => 'peso',
                'entry_category_id' => 1
            ],  
            [
                'name' => 'Edad', 
                'description' => 'Clase Edad',
                'value' => 'edad',
                'entry_category_id' => 1
            ],  
            // este es para mujeres
            [
                'name' => 'Cinturon', 
                'description' => 'Clase Cinturon',
                'value' => 'cinturon',
                'entry_category_id' => 2
            ],  
            [
                'name' => 'Peso', 
                'description' => 'Clase Peso',
                'value' => 'peso',
                'status' => false,
                'entry_category_id' => 2
            ],  
            [
                'name' => 'Edad', 
                'description' => 'Clase Edad',
                'value' => 'edad',
                'entry_category_id' => 2
            ],  

        ];

        foreach ($data as $key => $item) {
            ClassCategory::create($item);
        }
    }
}
