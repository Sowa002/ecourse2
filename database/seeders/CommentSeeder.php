<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\User;
use App\Models\Course;
use Faker\Factory as Faker;

class CommentSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $users = User::all();
        $courses = Course::all();

        foreach ($courses as $course) {
            foreach ($users as $user) {
                // Ensure only users who have purchased the course can comment
                if ($user->courses->contains($course)) {
                    Comment::create([
                        'user_id' => $user->id,
                        'course_id' => $course->id,
                        'comment' => $faker->sentence,
                        'rating' => $faker->numberBetween(1, 5),
                    ]);
                }
            }
        }
    }
}
