<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Academy;

class AcademySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'description' => 'CheckMat International',
                'federation_id' => 1
            ],
            [
                'description' => 'Gracie Barra',
                'federation_id' => 1
            ],
        ];

        foreach ($data as $key => $item) {
            Academy::create($item);
        }
    }
}
