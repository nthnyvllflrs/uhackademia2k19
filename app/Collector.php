<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collector extends Model
{
    protected $fillable = [
        'user_id', 'name', 'license_number', 'plate_number',
        'address', 'latitude', 'longitude',
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
