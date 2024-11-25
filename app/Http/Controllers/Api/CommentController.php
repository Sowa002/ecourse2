<?php

namespace App\Http\Controllers\Api;

use App\Models\Comment;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    // Method to add a comment and rating
    public function store(Request $request, $courseId)
    {
        $user = $request->user(); // Get the authenticated user

        // Validate the request
        $request->validate([
            'comment' => 'required|string|max:1000',
            'rating' => 'nullable|integer|min:1|max:5', // Ensure rating is between 1 and 5
        ]);

        $course = Course::find($courseId);

        // Check if the course exists and the user has purchased it
        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        if (!$user->courses->contains($course)) {
            return response()->json(['message' => 'You do not have access to this course'], 403);
        }

        // Create the comment with rating
        $comment = Comment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'comment' => $request->comment,
            'rating' => $request->rating,
        ]);

        return response()->json(['message' => 'Comment and rating added successfully', 'comment' => $comment]);
    }

    // Method to get comments and ratings for a course
    public function index($courseId)
    {
        $course = Course::find($courseId);

        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        $comments = $course->comments()->with('user')->get();

        return response()->json(['comments' => $comments]);
    }
}
