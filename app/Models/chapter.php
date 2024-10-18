<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class chapter extends Model
{
    public function course(): BelongsTo{
        return $this->belongsTo(Course::class);
    }

    public function video(): BelongsTo{
        return $this->belongsTo(Video::class);
    }
}
