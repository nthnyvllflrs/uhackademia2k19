<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'name', 'user_id'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
