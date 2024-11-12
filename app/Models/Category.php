<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Import HasFactory

class Category extends Model
{
    use HasFactory; // Use HasFactory trait

    protected $fillable = ['category_name'];

    public function course(): HasMany
    {
        return $this->hasMany(Course::class);
    }
}
