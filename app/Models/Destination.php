<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Gallery;

class Destination extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'user_id',
        'location',
        'description',
        'cover_path',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

}