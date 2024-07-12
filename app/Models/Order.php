<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'order_status';
    protected $fillable = [
        'name',
        'ownerId',
        'phonenumber',
        'detail',
        'duration',
        'price',
        'status',
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
