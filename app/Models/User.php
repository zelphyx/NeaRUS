<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'phonenumber',
        'photoprofile',
        'websiterole',
        'password',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat_rumah',
        'urgent_fullname',
        'urgent_status',
        'urgent_phonenumber',
        'email_verification_token',
        'buktiimage'
    ];

    // Ensure other parts of the model are as required
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $visible = [
        'id', 'name', 'email', 'phonenumber', 'websiterole', 'photoprofile', 'buktiimage',
        'jenis_kelamin', 'tanggal_lahir', 'alamat_rumah',
        'email_verified_at', 'created_at', 'updated_at',
        'data_pribadi', 'urgent_fullname', 'urgent_status', 'urgent_phonenumber'
    ];

    protected $primaryKey = 'ownerId';

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
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

    public function getKeyName()
    {
        return 'ownerId';
    }
}
