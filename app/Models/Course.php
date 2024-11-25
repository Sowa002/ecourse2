<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_code',
        'class_name',
        'description',
        'level',
        'price',
        'premium',
        'category_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($course) {
            $course->course_code = strtoupper(Str::random(5));
        });

        static::deleting(function ($course) {
            $course->chapters()->each(function ($chapter) {
                if ($chapter->videos()->exists()) {
                    $chapter->videos()->delete();
                }
                $chapter->delete();
            });
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function chapters(): HasMany
    {
        return $this->hasMany(Chapter::class);
    }

    public function users()
{
    return $this->belongsToMany(User::class, 'course_user');
}

public function comments()
{
    return $this->hasMany(Comment::class);
}


}
