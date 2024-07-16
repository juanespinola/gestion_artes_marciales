<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TypesVictory;

class TypeVictorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'description' => 'Submission',
            ],
            [
                'description' => 'W.O.',
            ],
            [
                'description' => 'Points',
            ],
            [
                'description' => 'Disqualification',
            ],
        ];

        foreach ($data as $key => $item) {
            TypesVictory::create($item);
        }
    }
}
