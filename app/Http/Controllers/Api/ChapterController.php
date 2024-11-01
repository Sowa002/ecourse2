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

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
