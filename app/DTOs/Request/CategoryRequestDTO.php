<?php

namespace App\DTOs\Request;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryRequestDTO
{
    public $category_name;

    public static function fromRequest(Request $request)
    {
        $messages = [
            'category_name.required' => 'The category name is required.',
        ];

        $validator = Validator::make($request->all(), [
            'category_name' => 'required|string|max:255',
        ], $messages);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        return new self($validator->validated());
    }

    public function __construct(array $data)
    {
        $this->category_name = $data['category_name'];
    }
}
