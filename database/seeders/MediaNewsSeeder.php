<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MediaNew;
use App\Models\News;

class MediaNewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // MediaNew::factory()->count(10)->create();

        $newIds = News::factory()->count(1)->create()->pluck('id');

        foreach ($newIds as $newId) {
            MediaNew::factory()->withBothImageTypes($newId);
        }

    }
}
