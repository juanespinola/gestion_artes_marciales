<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StatusEvent;

class StatusEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'description' => 'Organizando',
            ],
            [
                'description' => 'En curso',
            ],
            [
                'description' => 'Cancelado',
            ],
            [
                'description' => 'Postergado',
            ],
            [
                'description' => 'Finalizado',
            ],
            [
                'description' => 'Autorizado',
            ],
            [
                'description' => 'Pendiente Autorización',
            ],
        ];

        foreach ($data as $key => $item) {
            StatusEvent::create($item);
        }
    }
}
