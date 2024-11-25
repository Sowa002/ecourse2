<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = ['video_number', 'video_title', 'video_url', 'video_description', 'is_premium', 'chapter_id'];

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }
    public function users() 
    {
        return $this->belongsToMany(User::class, 'user_videos')->withPivot('watched')->withTimestamps(); 
    }
}
