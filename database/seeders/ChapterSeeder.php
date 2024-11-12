<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Chapter;
use App\Models\Course;

class ChapterSeeder extends Seeder
{
    public function run()
    {
        Course::all()->each(function ($course) {
            Chapter::factory()->count(3)->create([
                'course_id' => $course->id,
            ]);
        });
    }
}
