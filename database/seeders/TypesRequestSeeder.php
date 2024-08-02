<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TypeRequest;

class TypesRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'description' => 'Torneo',
                'federation_id' => 1,
            ],
            [
                'description' => 'Charlas',
                'federation_id' => 1,
            ],
            [
                'description' => 'Examén',
                'federation_id' => 1,
            ],
            [
                'description' => 'Seminario',
                'federation_id' => 1,
            ],
         
        ];

        foreach ($data as $key => $item) {
            TypeRequest::create($item);
        }
    }
}
