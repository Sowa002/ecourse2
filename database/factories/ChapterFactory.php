<?php

namespace Database\Factories;

use App\Models\Chapter;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChapterFactory extends Factory
{
    protected $model = Chapter::class;

    public function definition()
    {
        return [
            'chapter_name' => $this->faker->sentence,
            'course_id' => \App\Models\Course::factory(), // Assumes a relationship with Course model
            'chapter_number' => $this->faker->numberBetween(1, 10),
        ];
    }
}
