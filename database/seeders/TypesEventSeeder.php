<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TypesEvent;

class TypesEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'description' => 'Torneo',
            ],
            [
                'description' => 'Seminario',
            ],
            [
                'description' => 'Examen',
            ],
        ];

        foreach ($data as $key => $item) {
            TypesEvent::create($item);
        }
    }
}
