<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categories extends Model
{
    public function course(): HasMany{
        return $this->hasMany(Course::class);
    }
}