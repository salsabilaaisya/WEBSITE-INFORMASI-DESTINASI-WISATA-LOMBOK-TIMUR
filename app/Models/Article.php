<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title',
        'content',
        'thumbnail',
        'user_id',
        'published_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}