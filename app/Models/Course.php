<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Course extends Model
{
    protected $fillable = [
        'course_code', 
        'class_name', 
        'description', 
        'level', 
        'price', 
        'premium', 
        'category_id'
    ];
    
    public function category(): BelongsTo{
        return $this->belongsTo(Category::class);
    }

    public function chapters(): HasMany{
        return $this->hasMany(Chapter::class);
    }
}
