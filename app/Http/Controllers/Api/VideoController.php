<?php

namespace App\Http\Controllers\Api;

use App\Models\Video;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $videos = Video::all()->filter(function ($video) use ($user) {
            return $user->courses->contains($video->chapter->course);
        });
        
        return response()->json(['videos' => $videos], 200);
    }

    public function show($id, Request $request)
    {
        $video = Video::with('chapter.course')->find($id);
        if (!$video) {
            return response()->json(['message' => 'Video not found'], 404);
        }

        $course = $video->chapter->course;
        $user = $request->user();

        // Check if the user has purchased the course
        if ($user->courses->contains($course)) {
            return response()->json(['video' => $video], 200);
        } else {
            return response()->json(['message' => 'You do not have access to this video'], 403);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'video_number' => 'required|integer',
            'video_title' => 'required|string|max:255',
            'video_url' => 'required|string',
            'video_description' => 'required|string',
            'is_premium' => 'boolean',
            'chapter_id' => 'required|exists:chapters,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $video = Video::create($request->all());
        return response()->json(['video' => $video, 'message' => 'Video created successfully'], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'video_number' => 'required|integer',
            'video_title' => 'required|string|max:255',
            'video_url' => 'required|string',
            'video_description' => 'required|string',
            'is_premium' => 'boolean',
            'chapter_id' => 'required|exists:chapters,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $video = Video::find($id);
        if (!$video) {
            return response()->json(['message' => 'Video not found'], 404);
        }

        $video->update($request->all());
        return response()->json(['video' => $video, 'message' => 'Video updated successfully'], 200);
    }

    public function destroy($id)
    {
        $video = Video::find($id);
        if (!$video) {
            return response()->json(['message' => 'Video not found'], 404);
        }

        $video->delete();
        return response()->json(['message' => 'Video deleted successfully'], 200);
    }
}
