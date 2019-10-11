<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collector extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'user_id',
        'license_num',
        'plate_num',
        'location',
        'lat',
        'lng',
        'last_updated',
    ];
    
    public function user(){
        return $this->belongsTo('App\User');
    }
}
