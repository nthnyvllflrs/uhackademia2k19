<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'user_id',
        'barangay_id',
        'contact_number',
        'address',
        'lat',
        'lng',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function barangay(){
        return $this->belongsTo('App\Barangay');
    }
}
