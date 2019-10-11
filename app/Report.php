<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'user_id',
        'photo_url',
        'description',
        'lat',
        'lng',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
