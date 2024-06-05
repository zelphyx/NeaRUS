<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;



class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'photoprofile',
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

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $visible = [
        'id', 'name', 'email', 'phonenumber', 'websiterole','photoprofile',
        'jenis_kelamin', 'tanggal_lahir', 'alamat_rumah',
        'email_verified_at', 'created_at', 'updated_at',
        'data_pribadi','urgent_fullname',
        'urgent_status',
        'urgent_phonenumber'
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
    public function getKeyName()
    {
        return 'ownerId';
    }
}
