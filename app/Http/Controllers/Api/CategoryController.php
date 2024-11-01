<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::with('course')->get();
    
        $data = $categories->map(function ($category) {
            return [
                'id' => $category->id,
                'category_name' => $category->category_name,
                'course' => $category->course->map(function ($course) {
                    return [
                        'id' => $course->id,
                        'course_code' => $course->course_code,
                        'class_name' => $course->class_name,
                        'description' => $course->description,
                        'level' => $course->level,
                        'price' => $course->price,
                        'premium' => $course->premium,
                        'created_at' => $course->created_at,
                        'updated_at' => $course->updated_at,
                    ];
                }),
                'created_at' => $category->created_at,
                'updated_at' => $category->updated_at,
            ];
        });
    
        return new CategoryResource(true, 'Categories retrieved successfully', $data);
    }
    
    public function show($id)
    {
        $category = Category::with('course')->findOrFail($id);

        $data = [
            'id' => $category->id,
            'category_name' => $category->category_name,
            'course' => $category->course->map(function ($course) {
                return [
                    'id' => $course->id,
                    'course_code' => $course->course_code,
                    'class_name' => $course->class_name,
                    'description' => $course->description,
                    'level' => $course->level,
                    'price' => $course->price,
                    'premium' => $course->premium,
                    'created_at' => $course->created_at,
                    'updated_at' => $course->updated_at,
                ];
            }),
            'created_at' => $category->created_at,
            'updated_at' => $category->updated_at,
        ];


        return new CategoryResource(true, 'Category retrieved successfully', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|string|max:20',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $category = Category::create([
            'category_name' => $request->category_name
        ]);

        return new CategoryResource(true, 'Category created successfully', $category);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|string|max:20'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);   
        }

        $category = Category::findOrFail($id);

        $category->update([
            'category_name' => $request->category_name
        ]);
        
        return new CategoryResource(true, 'Category updated successfully', $category);
    }

    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        return new CategoryResource(true, 'Category deleted successfully', null);
    }
}
