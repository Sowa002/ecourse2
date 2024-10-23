<?php

namespace App\DTOs\Response;

class CourseResponseDTO
{
    public $status;
    public $data;

    public static function success($course)
    {
        $data = $course instanceof \Illuminate\Support\Collection
            ? $course->map(function ($item) {
                return [
                    'id' => $item->id,
                    'course_code' => $item->course_code,
                    'class_name' => $item->class_name,
                    'description' => $item->description,
                    'level' => $item->level,
                    'price' => $item->price,
                    'premium' => $item->premium,
                    'category' => [
                        'id' => $item->category->id,
                        'category_name' => $item->category->category_name,
                    ],
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            })->toArray()
            : [
                'id' => $course->id,
                'course_code' => $course->course_code,
                'class_name' => $course->class_name,
                'description' => $course->description,
                'level' => $course->level,
                'price' => $course->price,
                'premium' => $course->premium,
                'category' => [
                    'id' => $course->category->id,
                    'category_name' => $course->category->category_name,
                ],
                'created_at' => $course->created_at,
                'updated_at' => $course->updated_at,
            ];

        return new self([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public static function collection($courses)
    {
        return $courses->map(function ($course) {
            return self::success($course)->data;
        })->toArray();
    }

    public function __construct(array $data)
    {
        $this->status = $data['status'];
        $this->data = $data['data'];
    }
}
