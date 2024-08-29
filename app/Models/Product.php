<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $primaryKey = 'kostid';

    protected $fillable = [
        'image',
        'productname',
        'ownerId',
        'linklocation',
        'location',
        'category',
        'fasilitas',
        'roomid',
        'about',
        'duration',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'product_room', 'kostid', 'roomid');
    }
}
