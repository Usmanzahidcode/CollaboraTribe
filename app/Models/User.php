<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];
    public $timestamps = false;

//    Relations

    public function authoredProjects()
    {
        return $this->hasMany(Project::class,'author_id');
    }

    public function authoredComments()
    {
        return $this->hasMany(Comment::class,'author_id');
    }

}
