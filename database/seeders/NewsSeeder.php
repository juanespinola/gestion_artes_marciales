<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\News;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'title' => 'Noticia 1',
                'content' => "tenemos una prueba",
                "created_user_id" => 1,
                "federation_id" => 1,
            ],
            [
                'title' => 'Noticia 2',
                'content' => "tenemos una prueba",
                "created_user_id" => 1,
                "federation_id" => 2,
            ],
            [
                'title' => 'Noticia 3',
                'content' => "tenemos una prueba",
                "created_user_id" => 1,
                "federation_id" => 1,
                "association_id" => 2
            ],
            [
                'title' => 'Noticia 4',
                'content' => "tenemos una prueba",
                "created_user_id" => 1,
                "federation_id" => 1,
                "association_id" => 2
            ],
        ];

        foreach ($data as $key => $item) {
            News::create($item);
        }
    }
}
