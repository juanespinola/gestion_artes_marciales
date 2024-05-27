<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RuleCategory;

class RuleCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'class_category_id' => 1,  // clase cinturon 
                'value_category_id' => 1, // valor blanco
                'type' => '==', // es igual 
                'value' => 'blanco'
            ],  
            [
                'class_category_id' => 1,  // clase cinturon 
                'value_category_id' => 2, // valor azul
                'type' => '==', // es igual 
                'value' => 'azul'
            ],  
        ];

        foreach ($data as $key => $item) {
            RuleCategory::create($item);
        }
    }
}
