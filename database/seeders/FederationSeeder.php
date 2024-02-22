<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Federation;

class FederationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['description' => 'federacion 1'],
            ['description' => 'federacion 2'],
            ['description' => 'federacion 3'],
            ['description' => 'federacion 4'],
            ['description' => 'federacion 5'],
            ['description' => 'federacion 6'],
            ['description' => 'federacion 7'],
            ['description' => 'federacion 8'],
            ['description' => 'federacion 9'],
            ['description' => 'federacion 10'],
        ];

        foreach ($data as $key => $item) {

            Federation::create($item);

        }
    }
}
