<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\User;
use App\Models\Purchase;

class PurchaseSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $courses = Course::all();

        foreach ($users as $user) {
            foreach ($courses->random(rand(1, $courses->count())) as $course) {
                Purchase::create([
                    'user_id' => $user->id,
                    'course_id' => $course->id,
                    'transaction_id' => null,  // Set this to a valid transaction ID if needed
                    'status' => 'completed',  // Set initial status as completed for simplicity
                ]);
            }
        }
    }
}
