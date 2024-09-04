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
        'amount',
        'norekening',
        'targettransfer'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'ownerId');
    }
}
