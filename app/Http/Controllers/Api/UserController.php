<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\CourseResource;

class UserController extends Controller
{
    public function index()
    {
        Log::info('Fetching all users');

        try {
            $users = User::all();
            Log::info('Users retrieved successfully');
            return response()->json(['data' => $users], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching users: ' . $e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }
    
    public function checkRoles($user_id)
    {
        Log::info('Checking roles for user: ', ['user_id' => $user_id]);

        try {
            $user = User::findOrFail($user_id);
            $roles = $user->getRoleNames(); // Get all roles of the user
            Log::info('Roles retrieved successfully for user', ['roles' => $roles]);
            return response()->json(['roles' => $roles], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching roles: ' . $e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    // Method to display purchased courses
    public function purchasedCourses(Request $request)
    {
        Log::info('Fetching purchased courses for user: ', ['user_id' => $request->user()->id]);

        try {
            $user = $request->user();
            $courses = $user->courses()->wherePivot('status', 'completed')->with('category')->get();

            $data = $courses->map(function ($course) {
                return [
                    'id' => $course->id,
                    'course_code' => $course->course_code,
                    'class_name' => $course->class_name,
                    'description' => $course->description,
                    'level' => $course->level,
                    'price' => $course->price,
                    'premium' => $course->premium,
                    'category' => [
                        'id' => $course->category->id,
                        'category_name' => $course->category->category_name,
                    ],
                    'created_at' => $course->created_at,
                    'updated_at' => $course->updated_at,
                ];
            });

            Log::info('Purchased courses retrieved successfully');
            return new CourseResource(true, 'Purchased courses retrieved successfully', $data);
        } catch (\Exception $e) {
            Log::error('Error fetching purchased courses: ' . $e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }
}
