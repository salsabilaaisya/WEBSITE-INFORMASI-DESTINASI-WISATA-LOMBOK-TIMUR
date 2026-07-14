<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class About extends Model
{
    use HasFactory;

    protected $fillable = [

        'title',
        'short_description',
        'description',

        'vision',
        'mission',

        'image',

        'address',
        'phone',
        'email',

        'facebook',
        'instagram',
        'youtube',

    ];
}