<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class video extends Model
{
    public function chapter(): BelongsTo{
        return $this->belongsTo(chapter::class);
    }
}
