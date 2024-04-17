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
            [
                'description' => 'Federacion Paraguaya de Jiu Jitsu'
            ],
            [
                'description' => 'Federacion Paraguaya de Karate'
            ],
            [
                'description' => 'Federacion Paraguaya de Taekwondo'
            ]
        ];

        foreach ($data as $key => $item) {

            Federation::create($item);

        }
    }
}
