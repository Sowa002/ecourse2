<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = ['Programming', 'Design', 'Marketing', 'Business', 'Photography', 'Art', 'Science', 'Technology'];

        foreach ($categories as $category_name) {
            if (Category::where('category_name', $category_name)->doesntExist()) {
                Category::create(['category_name' => $category_name]);
            }
        }
    }
}
