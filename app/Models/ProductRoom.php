<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRoom extends Model
{
    use HasFactory;

    protected $table = 'product_room';

    protected $fillable = [
        'product_id',
        'room_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
