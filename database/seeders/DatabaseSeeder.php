<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate the tables
        DB::table('categories')->truncate();
        DB::table('courses')->truncate();
        DB::table('chapters')->truncate();
        DB::table('videos')->truncate();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->call([
            CategorySeeder::class,
            CourseSeeder::class,
            ChapterSeeder::class,
            VideoSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}
