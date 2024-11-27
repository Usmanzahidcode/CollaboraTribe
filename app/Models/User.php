<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture',
        'bio',
        'cp',
        'role',
        'status',
        'github',
        'email_verified_at',
        'email_verification_token',
        'reset_password_token',
        'reset_password_token_at',
        'remember_token',
    ];

    // Eloquent Relations

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'author_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'author_id');
    }

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'email_verified_at' => 'datetime'
        ];
    }

}
