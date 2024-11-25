<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'course_id' => Course::factory(),
            'comment' => $this->faker->sentence,
            'rating' => $this->faker->numberBetween(1, 5),
        ];
    }
}
