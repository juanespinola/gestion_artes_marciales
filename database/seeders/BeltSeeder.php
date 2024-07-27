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
                'color' => 'Blanco',
                'federation_id' => '1',
            ],  
            [
                'color' => 'Azul',
                'federation_id' => '1',
            ],  
            [
                'color' => 'Lila',
                'federation_id' => '1',
            ],  
            [
                'color' => 'Marrón',
                'federation_id' => '1',
            ],  
            [
                'color' => 'Negro',
                'federation_id' => '1',
            ],  
        ];

        foreach ($data as $key => $item) {
            Belt::create($item);
        }
    }
}
