<?php

namespace App\Http\Controllers\Api;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CourseController extends Controller
{
    public function index()
    {
    $courses = Course::with('category')->paginate(2);
    $data = $courses->items();
    $data = array_map(function ($item) {
        return [
            'id' => $item->id,
            'course_code' => $item->course_code,
            'class_name' => $item->class_name,
            'description' => $item->description,
            'level' => $item->level,
            'price' => $item->price,
            'premium' => $item->premium,
            'category' => [
                'id' => $item->category->id,
                'category_name' => $item->category->category_name,
            ],
            'created_at' => $item->created_at,
            'updated_at' => $item->updated_at,
        ];
    }, $data);

    $paginatedData = [
        'current_page' => $courses->currentPage(),
        'per_page' => $courses->perPage(),
        'total' => $courses->total(),
        'last_page' => $courses->lastPage(),
        'data' => $data,
    ];
    
        return new CourseResource(true, 'Courses retrieved successfully', $paginatedData);
    }

    public function show($id)
    {
        $course = Course::with(['category', 'chapters'])->findOrFail($id);

        $data = [
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
            'chapters' => $course->chapters->map(function ($chapter) {
                return [
                    'id' => $chapter->id,
                    'chapter_number' => $chapter->chapter_number,
                    'chapter_name' => $chapter->chapter_name,
                ];
            }),
        ];

        return new CourseResource(true, 'Course retrieved successfully', $data);
    }

    public function searchByClassName($class_name)
    {
        if (empty($class_name) || !is_string($class_name) || strlen($class_name) > 100) {
            return response()->json(['message' => 'Invalid class name.'], 400);
        }
    
        $courses = Course::with('category')->where('class_name', 'like', '%' . $class_name . '%')->get();
    
        if ($courses->isEmpty()) {
            return response()->json(['message' => 'No courses found.'], 404);
        }
    
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
    
        return new CourseResource(true, 'Courses retrieved successfully', $data);
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class_name' => 'required|string|max:255',
            'description' => 'required|string',
            'level' => 'required|string|in:pemula,menengah,ahli',
            'price' => 'required|numeric',
            'premium' => 'boolean',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $course = Course::create([
            'class_name' => $request->class_name,
            'description' => $request->description,
            'level' => $request->level,
            'price' => $request->price,
            'premium' => $request->premium,
            'category_id' => $request->category_id,
        ]);

        return new CourseResource(true, 'Course created successfully', $course);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'class_name' => 'required|string|max:255',
            'description' => 'required|string',
            'level' => 'required|string|in:pemula,menengah,ahli',
            'price' => 'required|numeric',
            'premium' => 'boolean',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $course = Course::findOrFail($id);

        $course->update([
            'class_name' => $request->class_name,
            'description' => $request->description,
            'level' => $request->level,
            'price' => $request->price,
            'premium' => $request->premium,
            'category_id' => $request->category_id,
        ]);
        
        return new CourseResource(true, 'Course updated successfully', $course);
    }

    public function destroy($id)
    {
        try {
            // Temukan course berdasarkan ID atau lempar exception jika tidak ditemukan
            $course = Course::findOrFail($id);
    
            // Hapus course yang akan otomatis menghapus chapters dan videos
            $course->delete();
    
            return new CourseResource(true, 'Course deleted successfully', null);
        } catch (ModelNotFoundException $e) {
            return new CourseResource(false, 'Failed to delete course because ' . $e ,  null);
        }
    }
}
