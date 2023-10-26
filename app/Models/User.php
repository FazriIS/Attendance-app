<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthApi;

class User extends Model implements AuthApi
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    public function getAuthIdentifierName()
    {
        return 'username';
    }

    public function getAuthIdentifier()
    {
        return $this->username;
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return $this->token;
    }

    public function setRememberToken($value)
    {
        $this->token = $value;
    }

    public function getRememberTokenName()
    {
        return 'token';
    }

    public function MappingShift()
    {
        return $this->hasMany(MappingShift::class);
    }
    
    public function dinasLuar()
    {
        return $this->hasMany(dinasLuar::class);
    }
    
    public function Sip()
    {
        return $this->hasMany(Sip::class);
    }

    public function Lembur()
    {
        return $this->hasMany(Lembur::class);
    }

    public function Cuti()
    {
        return $this->hasMany(Cuti::class);
    }

    public function Jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function Lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
