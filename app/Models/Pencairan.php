<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pencairan extends Model
{
    use HasFactory;
    protected $table = 'request_disbursement';
    protected $fillable = [
        'id',
        'ownerId',
        'name',
        'phonenumber',
        'amount'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
