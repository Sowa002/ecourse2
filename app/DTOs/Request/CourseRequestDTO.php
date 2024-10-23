<?php

namespace App\DTOs\Request;

use Illuminate\Http\Request;

class CourseRequestDTO
{
    public $course_code;
    public $class_name;
    public $description;
    public $level;
    public $price;
    public $premium;
    public $category_id;

    public static function fromRequest(Request $request)
    {
        $request->validate([
            'course_code' => 'required|string|max:5|unique:courses,course_code',
            'class_name' => 'required|string|max:255',
            'description' => 'required|string',
            'level' => 'required|string|in:pemula,menengah,ahli',
            'price' => 'required|numeric',
            'premium' => 'boolean',
            'category_id' => 'required|exists:categories,id',
        ]);

        return new self([
            'course_code' => $request->input('course_code'),
            'class_name' => $request->input('class_name'),
            'description' => $request->input('description'),
            'level' => $request->input('level'),
            'price' => $request->input('price'),
            'premium' => $request->input('premium'),
            'category_id' => $request->input('category_id'),
        ]);
    }

    public function __construct(array $data)
    {
        $this->course_code = $data['course_code'];
        $this->class_name = $data['class_name'];
        $this->description = $data['description'];
        $this->level = $data['level'];
        $this->price = $data['price'];
        $this->premium = $data['premium'];
        $this->category_id = $data['category_id'];
    }
}
