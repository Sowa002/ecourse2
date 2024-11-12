<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition()
    {
        return [
            'class_name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'level' => $this->faker->randomElement(['pemula', 'menengah', 'ahli']), // Updated to match enum values
            'price' => $this->faker->randomFloat(2, 100, 1000),
            'premium' => $this->faker->boolean,
            'category_id' => \App\Models\Category::factory(),
        ];
    }
}
