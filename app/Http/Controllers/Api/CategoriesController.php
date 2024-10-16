<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoriesResource;
use App\Models\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Categories::with('course')->get();
        return CategoriesResource::collection($categories);
    }

    public function show($id)
    {
        $category = Categories::with('course')->findOrFail($id);
        return new CategoriesResource($category);
    }

    public function store(Request $request)
    {
        $category = Categories::create($request->all());
        return new CategoriesResource($category);
    }

    public function update(Request $request, $id)
    {
        $category = Categories::findOrFail($id);
        $category->update($request->all());
        return new CategoriesResource($category);
    }

    public function destroy($id)
    {
        Categories::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
