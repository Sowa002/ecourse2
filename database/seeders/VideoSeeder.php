<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Video;
use App\Models\Chapter;
use Faker\Factory as Faker;

class VideoSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $chapters = Chapter::all();

        foreach ($chapters as $chapter) {
            for ($i = 1; $i <= 3; $i++) {
                Video::create([
                    'video_number' => $i,
                    'video_title' => $faker->sentence,
                    'video_url' => $faker->url,
                    'video_description' => $faker->paragraph,
                    'is_premium' => false,
                    'chapter_id' => $chapter->id,
                ]);
            }
        }
    }
}
