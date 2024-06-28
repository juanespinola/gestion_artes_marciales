<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CategoryNew;

class CategoryNewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'description' => 'torneos',
            ],
            [
                'description' => 'charlas',
            ],
            [
                'description' => 'avisos',
            ],
            [
                'description' => 'otros',
            ],
        ];

        foreach ($data as $key => $item) {
            CategoryNew::create($item);
        }
    }
}
