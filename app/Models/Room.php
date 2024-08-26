<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $table = 'rooms';
    protected $primaryKey = 'roomid';

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_room', 'roomid', 'kostid');
    }
    protected $fillable = [

        'ownerId',
        'kostid',
        'name',
        'category',
        'fasilitas',
        'image',
        'price',
        'time',
        'availability'
    ];

    protected $hidden = [
        "created_at",
        "updated_at",
        "remember_token"
    ];
}
