<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

public function purchases() 
{ 
    return $this->hasMany(Purchase::class);
}

public function courses()
{
    return $this->belongsToMany(Course::class, 'purchases')->withTimestamps();
}

public function comments()
{
    return $this->hasMany(Comment::class);
}

public function videos()
{
    return $this->belongsToMany(Video::class, 'user_videos')->withPivot('watched')->withTimestamps();
}


}
