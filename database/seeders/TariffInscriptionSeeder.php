<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TariffInscription;

class TariffInscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'entry_category_id' => '1',
                'price' => '1',
            ],
            [
                'entry_category_id' => '2',
                'price' => '1',
            ],
            [
                'entry_category_id' => '3',
                'price' => '1',
            ],
            [
                'entry_category_id' => '4',
                'price' => '1',
            ],
            [
                'entry_category_id' => '5',
                'price' => '1',
            ],
            [
                'entry_category_id' => '6',
                'price' => '1',
            ],
            [
                'entry_category_id' => '7',
                'price' => '1',
            ],
            [
                'entry_category_id' => '8',
                'price' => '1',
            ],
            [
                'entry_category_id' => '9',
                'price' => '1',
            ],
            [
                'entry_category_id' => '10',
                'price' => '1',
            ],
            [
                'entry_category_id' => '11',
                'price' => '1',
            ],
            [
                'entry_category_id' => '12',
                'price' => '1',
            ],
            [
                'entry_category_id' => '13',
                'price' => '1',
            ],
            
        ];

        foreach ($data as $key => $item) {
            TariffInscription::create($item);
        }
    }
}
