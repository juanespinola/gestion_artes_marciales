<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sport;

class SportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['description' => 'Jiu Jitsu'],
            ['description' => 'Karate'],
            ['description' => 'Taekwondo'],
        ];

        foreach ($data as $key => $item) {
            Sport::create($item);
        }
    }
}
