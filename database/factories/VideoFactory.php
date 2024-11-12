<?php

namespace Database\Factories;

use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoFactory extends Factory
{
    protected $model = Video::class;

    public function definition()
    {
        return [
            'video_number' => $this->faker->numberBetween(1, 20),
            'video_title' => $this->faker->sentence,
            'video_url' => $this->faker->url,
            'video_description' => $this->faker->paragraph,
            'is_premium' => $this->faker->boolean,
            'chapter_id' => \App\Models\Chapter::factory(),
        ];
    }
}
