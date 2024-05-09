<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;
    protected $table = 'owner_request';
    protected $fillable = [
        'name',
        'websiterole',
        'email',
        'phonenumber',
        'password',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat_rumah',
        'urgent_fullname',
        'urgent_status',
        'urgent_phonenumber',
        'email_verification_token'
    ];
    protected $hidden = [
        'password',
    ];

    public function getDataPribadiAttribute()
    {
        return [
            'Jenis Kelamin' => $this->jenis_kelamin,
            'Tanggal Lahir' => $this->tanggal_lahir,
            'Alamat Rumah' => $this->alamat_rumah,
            'urgent_fullname' => $this->urgent_fullname,
            'urgent_status' => $this->urgent_status,
            'urgent_phonenumber' => $this->urgent_phonenumber
        ];
    }
    protected $primaryKey = 'ownerId';
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
