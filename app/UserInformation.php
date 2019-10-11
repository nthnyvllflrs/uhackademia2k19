<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInformation extends Model
{
    protected $fillable = [
        'user_id', 'firstname', 'lastname', 
        'address', 'latitude', 'longitude',
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
