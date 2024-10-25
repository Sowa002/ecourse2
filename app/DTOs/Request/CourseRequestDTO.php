<?php

namespace App\DTOs\Request;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $messages = [
            'course_code.required' => 'The course code is required.',
            'course_code.unique' => 'The course code is already taken. Please use a different course code.',
            'class_name.required' => 'The class name is required.',
            'description.required' => 'The description is required.',
            'level.required' => 'The level is required.',
            'price.required' => 'The price is required.',
            'price.numeric' => 'The price must be a number.',
            'category_id.required' => 'The category ID is required.',
            'category_id.exists' => 'The category ID must exist in the categories table.',
        ];

        $validatedData = Validator::make($request->all(), [
            'course_code' => 'required|string|max:5|unique:courses,course_code',
            'class_name' => 'required|string|max:255',
            'description' => 'required|string',
            'level' => 'required|string|in:pemula,menengah,ahli',
            'price' => 'required|numeric',
            'premium' => 'boolean',
            'category_id' => 'required|exists:categories,id',
        ], $messages)->validate();

        return new self($validatedData);
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
