<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        static $uniqueCategoryName = [];

        do {
            $name = $this->faker->unique()->word;
        } while (in_array($name, $uniqueCategoryName));

        $uniqueCategoryName[] = $name;

        return [
            'category_name' => $name,
        ];
    }
}
