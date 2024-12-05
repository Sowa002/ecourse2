<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'guard_name'];

    // Isi guard_name secara otomatis jika tidak diisi
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($role) {
            if (empty($role->guard_name)) {
                $role->guard_name = 'web'; // Default value untuk guard_name
            }
        });
    }

    // Relasi dengan model User
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
