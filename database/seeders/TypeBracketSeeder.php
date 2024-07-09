<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TypeBracket;

class TypeBracketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'description' => 'Single elimination bracket (Sin Pelea de Bronce)',
            ],
            [
                'description' => 'Single elimination bracket (Con Pelea de Bronce)',
            ],
        ];

        foreach ($data as $key => $item) {
            TypeBracket::create($item);
        }
    }
}
