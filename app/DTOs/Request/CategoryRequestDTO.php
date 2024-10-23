<?php

namespace App\DTOs\Request;

use Illuminate\Http\Request;

class CategoryRequestDTO
{
    public $category_name;

    public static function fromRequest(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        return new self([
            'category_name' => $request->input('category_name'),
        ]);
    }

    public function __construct(array $data)
    {
        $this->category_name = $data['category_name'];
    }
}
