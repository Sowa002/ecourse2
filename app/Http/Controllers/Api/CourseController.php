<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('category')->get();
    return CourseResource::collection($courses);
    }

    public function show($id)
    {
        $course = Course::with('category')->findOrFail($id);
        return new CourseResource($course);
    }

    public function store(Request $request)
    {
        $course = Course::create($request->all());
        return new CourseResource($course);
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $course->update($request->all());
        return new CourseResource($course);
    }

    public function destroy($id)
    {
        Course::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
