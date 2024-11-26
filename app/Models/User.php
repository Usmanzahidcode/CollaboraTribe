<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Eloquent Relations
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class,'author_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class,'author_id');
    }

}
