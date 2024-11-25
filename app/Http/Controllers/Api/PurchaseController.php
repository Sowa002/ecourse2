<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PurchaseController extends Controller
{
    // Method to handle course purchase
    public function purchaseCourse($courseId, Request $request)
    {
        $user = $request->user(); // Get the authenticated user
        $course = Course::find($courseId); // Get the course by ID

        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        // Add entry to pivot table to track the purchase
        if (!$user->courses->contains($course)) {
            $user->courses()->attach($course);
        }

        return response()->json(['message' => 'Course purchased successfully']);
    }
}
