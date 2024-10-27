<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class chapter extends Model
{

    protected $fillable = [
        'chapter_name',
        'course_id',
        'chapter_number',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($chapter) {
            $lastChapter = Chapter::where('course_id', $chapter->course_id)
                ->orderBy('chapter_number', 'desc')
                ->first();

            $chapter->chapter_number = $lastChapter ? $lastChapter->chapter_number + 1 : 1;
        });
    }



    public function course(): BelongsTo{
        return $this->belongsTo(Course::class);
    }

    public function video(): BelongsTo{
        return $this->belongsTo(Video::class);
    }
}
