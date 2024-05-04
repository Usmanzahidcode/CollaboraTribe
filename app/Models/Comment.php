<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function author()
    {
        return $this->belongsTo(User::class,'author_id');
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
