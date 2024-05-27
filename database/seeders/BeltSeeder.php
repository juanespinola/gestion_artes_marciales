<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Belt;

class BeltSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'description' => 'Blanco',
                'federation_id' => 1
            ],  
            [
                'description' => 'Azul',
                'federation_id' => 1
            ],  
            [
                'description' => 'Lila',
                'federation_id' => 1
            ],  
            [
                'description' => 'Marrón',
                'federation_id' => 1
            ],  
            [
                'description' => 'Negro',
                'federation_id' => 1
            ],  
        ];

        foreach ($data as $key => $item) {
            Belt::create($item);
        }
    }
}
