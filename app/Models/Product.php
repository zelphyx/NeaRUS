<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'productname',
        'ownerId',
        'linklocation',
        'location',
        'category',
        'fasilitas',
        'roomid',
        'about'
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];
}
