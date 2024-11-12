<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Video;
use App\Models\Chapter;

class VideoSeeder extends Seeder
{
    public function run()
    {
        Chapter::all()->each(function ($chapter) {
            Video::factory()->count(5)->create([
                'chapter_id' => $chapter->id,
            ]);
        });
    }
}
