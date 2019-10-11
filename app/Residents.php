<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Residents extends Model
{
    protected $fillable = [
        'user_id', 'barangay_id', 'fullname', 
        'address', 'latitude', 'longitude',
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function barangay() {
        return $this->belongsTo('App\Barangay');
    }
}
