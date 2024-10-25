<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\DTOs\Request\CategoryRequestDTO;
use App\DTOs\Response\CategoryResponseDTO;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('course')->get();
        return response()->json(CategoryResponseDTO::success($categories), 200);
    }

    public function show($id)
    {
        $category = Category::with('course')->findOrFail($id);
        return response()->json(CategoryResponseDTO::success($category), 200);
    }

    public function store(Request $request)
    {
        try {
            $categoryDTO = CategoryRequestDTO::fromRequest($request);
            $category = Category::create((array) $categoryDTO);
            return response()->json(CategoryResponseDTO::success($category), 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
    
    public function update(Request $request, $id)
    {
        try {
            $categoryDTO = CategoryRequestDTO::fromRequest($request);
            $category = Category::findOrFail($id);
            $category->update((array) $categoryDTO);
            return response()->json(CategoryResponseDTO::success($category), 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
    
    
    

    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        return response()->json(['status' => 'success', 'data' => null], 204);
    }
}
