<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use App\DTOs\Request\CourseRequestDTO;
use App\DTOs\Response\CourseResponseDTO;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('category')->get();
        return response()->json(CourseResponseDTO::success($courses), 200);
    }

    public function show($id)
    {
        $course = Course::with('category')->findOrFail($id);
        return response()->json(CourseResponseDTO::success($course), 200);
    }

    public function store(Request $request)
    {
        try {
            $courseDTO = CourseRequestDTO::fromRequest($request);
            $course = Course::create((array) $courseDTO);
            return response()->json(CourseResponseDTO::success($course), 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $courseDTO = CourseRequestDTO::fromRequest($request);
            $course = Course::findOrFail($id);
            $course->update((array) $courseDTO);
            return response()->json(CourseResponseDTO::success($course), 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy($id)
    {
        Course::findOrFail($id)->delete();
        return response()->json(['status' => 'success', 'data' => null], 204);
    }
}
