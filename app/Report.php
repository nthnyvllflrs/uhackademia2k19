<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'resident_id', 'description', 'photo', 
        'address', 'latitude', 'longitude',
    ];

    public function resident() {
        return $this->belongsTo('App\Resident');
    }
}
