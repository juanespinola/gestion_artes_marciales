<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TypeMembership;

class TypesMembershipsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'description' => 'Membresia Asociacion',
                'price' => 10000,
                'total_number_fee' => 12,
                'federation_id' => 1,
                'association_id' => 2,
            ],
           
        ];

        foreach ($data as $key => $item) {
            TypeMembership::create($item);
        }
    }
}
