<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Association;

class AssociationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'description' => 'asociacion 1'
            ],
            [
                'description' => 'asociacion 2'
            ],
        ];

        foreach ($data as $key => $item) {

            Association::create($item);

        }
    }
}
