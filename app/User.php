<?php

namespace App;

use Laravel\Passport\HasApiTokens;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'username', 'password', 'role', 'verified',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function barangay() {
        return $this->hasOne('App\Barangay');
    }

    public function resident() {
        return $this->hasOne('App\Resident');
    }

    public function collector() {
        return $this->hasOne('App\Collector');
    }
}
