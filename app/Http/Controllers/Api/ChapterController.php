<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChapterResource;
use App\Models\chapter;
use Illuminate\Support\Facades\Validator;

class ChapterController extends Controller
{

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'chapter_name' => 'required|string|max:20',
            'course_id' => 'required|exists:courses,id',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $chapter = Chapter::create([
            'chapter_name' => $request->chapter_name,
            'course_id' => $request->course_id,
        ]);

        return new ChapterResource(true, 'Chapter created successfully', $chapter);

    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'chapter_name' => 'required|string|max:20',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $chapter = Chapter::find($id);

        if (!$chapter) {
            return response()->json(['message' => 'Chapter not found.'], 404);
        }

        $chapter->update([
            'chapter_name' => $request->chapter_name
        ]);

        return new ChapterResource(true, 'Chapter updated successfully', $chapter);
    }

    public function destroy(string $id)
    {
        //
    }
}
