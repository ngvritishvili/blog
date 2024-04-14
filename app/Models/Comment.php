<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'author',
        'post_id',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'author');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
