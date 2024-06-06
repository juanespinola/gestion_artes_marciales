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
                'badge' => '4',
            ],  
            [
                'color' => 'Azul',
                'badge' => '4',
            ],  
            [
                'color' => 'Lila',
                'badge' => '4',
            ],  
            [
                'color' => 'Marrón',
                'badge' => '4',
            ],  
            [
                'color' => 'Negro',
                'badge' => '4',
            ],  
        ];

        foreach ($data as $key => $item) {
            Belt::create($item);
        }
    }
}
