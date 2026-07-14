<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'destination_id',
        'title',
        'caption',
        'image',
    ];

    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->image);
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
}
