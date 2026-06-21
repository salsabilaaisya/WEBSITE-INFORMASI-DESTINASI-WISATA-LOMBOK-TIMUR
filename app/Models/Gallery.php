<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'destination_id',
        'image',
        'caption',
    ];

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
}