<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'description' => 'Torneo Verano',
                'location_id' => '1',
                'initial_date' => '04/04/2024',
                'event_type_id' => '1',
                'event_status_id' => '1',
                'inscription_fee' => '100',
                'available_slots' => '100',
                'created_user_id' => '3',
                'federation_id'=> '1',
            ],
            [
                'description' => 'Torneo Invierno',
                'location_id' => '1',
                'initial_date' => '04/04/2024',
                'event_type_id' => '1',
                'event_status_id' => '1',
                'inscription_fee' => '100',
                'available_slots' => '100',
                'created_user_id' => '4',
                'federation_id'=> '1',
                'association_id'=> '2',
            ],
        ];

        foreach ($data as $key => $item) {
            Event::create($item);
        }
    }
}
