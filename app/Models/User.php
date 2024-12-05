<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id', // Menggunakan role_id untuk referensi ke tabel roles
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

    // Implementasi metode yang diperlukan oleh JWTSubject
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    // Relasi ke tabel roles
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Metode untuk memeriksa peran pengguna
    public function hasRole($roleName)
    {
        return $this->role->name === $roleName;
    }
}
