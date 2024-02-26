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
            ['description' => 'federacion 11'],
            ['description' => 'federacion 12'],
            ['description' => 'federacion 13'],
            ['description' => 'federacion 14'],
            ['description' => 'federacion 15'],
            ['description' => 'federacion 16'],
            ['description' => 'federacion 17'],
            ['description' => 'federacion 18'],
            ['description' => 'federacion 19'],
            ['description' => 'federacion 20'],
        ];

        foreach ($data as $key => $item) {

            Federation::create($item);

        }
    }
}
