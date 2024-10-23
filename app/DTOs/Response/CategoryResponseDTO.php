<?php

namespace App\DTOs\Response;

class CategoryResponseDTO
{
    public $status;
    public $data;

    public static function success($category)
    {
        $data = $category instanceof \Illuminate\Support\Collection
            ? $category->map(function ($item) {
                return [
                    'id' => $item->id,
                    'category_name' => $item->category_name,
                    'course' => $item->course->map(function ($course) {
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
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            })->toArray()
            : [
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

        return new self([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function __construct(array $data)
    {
        $this->status = $data['status'];
        $this->data = $data['data'];
    }
}
