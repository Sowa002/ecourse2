<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Course extends Model
{
    public function category(): BelongsTo{
        return $this->belongsTo(Categories::class);
    }
}
