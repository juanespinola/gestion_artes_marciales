<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TypeDocument;

class TypeDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'description' => 'Cédula de Identidad',
            ],
            [
                'description' => 'Registro Único de Contribuyente',
            ],
        ];

        foreach ($data as $key => $item) {
            TypeDocument::create($item);
        }
    }
}
